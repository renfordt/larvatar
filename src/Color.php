<?php

namespace Renfordt\Larvatar;

use Exception;
use InvalidArgumentException;
use Renfordt\Larvatar\Enum\ColorType;

class Color
{
    private string $hex;
    private array $rgb;
    private array $hsv;
    private array $hsl;

    public function __construct(ColorType $type, array|string $color)
    {
        switch ($type) {
            case ColorType::Hex:
                $this->setHex($color);
                break;
            case ColorType::RGB:
                $this->setRGB($color);
                break;
            case ColorType::HSL:
                $this->setHSL($color);
        }
    }

    /**
     * Convert a Hex color to an RGB color
     * @param  string  $hexStr  Both hex formats, 3 and 6 characters, are supported, e.g. FFF or FFFFFF.
     * @return array Array with red, green and blue value { [0..255], [0..255], [0..255] }
     */
    public static function HexToRGB(string $hexStr): array
    {
        $hexStr = str_replace('#', '', $hexStr);
        $length = strlen($hexStr);

        if (!in_array($length, [3, 6]) || preg_match("/^[0-9a-fA-F]+$/", $hexStr) !== 1) {
            throw new InvalidArgumentException('Invalid Hex format.');
        }

        $hexStr = preg_replace("/[^0-9A-Fa-f]/", '', $hexStr);
        if ($length === 6) {
            $colorVal = hexdec($hexStr);

            return array(
                0xFF & ($colorVal >> 0x10),
                0xFF & ($colorVal >> 0x8),
                0xFF & $colorVal
            );
        }

        return array(
            hexdec(str_repeat(substr($hexStr, 0, 1), 2)),
            hexdec(str_repeat(substr($hexStr, 1, 1), 2)),
            hexdec(str_repeat(substr($hexStr, 2, 1), 2))
        );
    }

    /**
     * Converts a rgb color to an HSL color
     * @param  int  $red  Value of red [0..255]
     * @param  int  $green  Value of green [0..255]
     * @param  int  $blue  Value of blue [0..255]
     * @return array|float[]|int[] Array of hue, saturation and lightness
     * { [0..360], [0..1], [0..1] }
     *
     */
    public static function RGBToHSL(int $red, int $green, int $blue): array
    {
        list($maxRGB, $minRGB, $chroma, $value, $hue) = self::calculateCVH($red, $green, $blue);

        if ($chroma == 0) {
            return array(0, 0, $value);
        }

        $lightness = ($maxRGB + $minRGB) / 2;
        $saturation = $chroma / (1 - abs(2 * $value - $chroma - 1));


        return array(round($hue), round($saturation, 2), round($lightness, 2));
    }

    /**
     * Converts a rgb color to an HSV color
     * @param  int  $red  Value of red [0..255]
     * @param  int  $green  Value of green [0..255]
     * @param  int  $blue  Value of blue [0..255]
     * @return array|float[]|int[] Array of hue, saturation and value/brightness
     * { [0..360], [0..1], [0..1] }
     *
     */
    public static function RGBToHSV(int $red, int $green, int $blue): array
    {
        list($maxRGB, $minRGB, $chroma, $value, $hue) = self::calculateCVH($red, $green, $blue);

        if ($chroma == 0) {
            return array(0, 0, $value);
        }

        $saturation = $chroma / $maxRGB * 100;


        return array($hue, $saturation, $value);
    }

    /**
     * Converts a HSV value to a RGB
     * @param  int  $hue  Hue value [0..360]
     * @param  float  $saturation  Saturation value [0..1]
     * @param  float  $value  Brightness value [0..1]
     * @return array|int[]
     * @throws Exception|InvalidArgumentException
     */
    public static function HSVToRGB(int $hue, float $saturation, float $value): array
    {
        if ($hue < 0 || $hue > 360 ||
            $saturation < 0 || $saturation > 1 ||
            $value < 0 || $value > 1) {
            throw new InvalidArgumentException('Parameters exceed their intended ranges.');
        }

        $chroma = $value * $saturation;
        $hueNormalized = $hue / 60;
        $hMod2 = $hueNormalized - 2 * floor($hueNormalized / 2);
        $secondMax = $chroma * (1 - abs($hMod2 - 1));

        if (0 <= $hueNormalized && $hueNormalized < 1) {
            list($r, $g, $b) = array($chroma, $secondMax, 0);
        } elseif (1 <= $hueNormalized && $hueNormalized < 2) {
            list($r, $g, $b) = array($secondMax, $chroma, 0);
        } elseif (2 <= $hueNormalized && $hueNormalized < 3) {
            list($r, $g, $b) = array(0, $chroma, $secondMax);
        } elseif (3 <= $hueNormalized && $hueNormalized < 4) {
            list($r, $g, $b) = array(0, $secondMax, $chroma);
        } elseif (4 <= $hueNormalized && $hueNormalized < 5) {
            list($r, $g, $b) = array($secondMax, 0, $chroma);
        } elseif (5 <= $hueNormalized && $hueNormalized < 6) {
            list($r, $g, $b) = array($chroma, 0, $secondMax);
        }
        if (!isset($r) || !isset($g) || !isset($b)) {
            throw new Exception('RGB calculation not possible. Check inputs!');
        }
        $m = $value - $chroma;
        $r = intval(round(($r + $m) * 255));
        $g = intval(round(($g + $m) * 255));
        $b = intval(round(($b + $m) * 255));

        return array($r, $g, $b);
    }

    /**
     * Converts an RGB color to a hex color
     * @param  int  $red  [0..255]
     * @param  int  $green  [0..255]
     * @param  int  $blue  [0..255]
     * @return string
     */
    public static function RGBToHex(int $red, int $green, int $blue): string
    {
        $hexr = str_pad(dechex($red), 2, "0", STR_PAD_LEFT);
        $hexg = str_pad(dechex($green), 2, "0", STR_PAD_LEFT);
        $hexb = str_pad(dechex($blue), 2, "0", STR_PAD_LEFT);
        return $hexr.$hexg.$hexb;
    }

    /**
     * @param  int  $red
     * @param  int  $green
     * @param  int  $blue
     * @return array
     */
    public static function calculateCVH(int $red, int $green, int $blue): array
    {
        $normalizedRed = $red / 255;
        $normalizedGreen = $green / 255;
        $normalizedBlue = $blue / 255;

        $maxRGB = max($normalizedRed, $normalizedGreen, $normalizedBlue);
        $minRGB = min($normalizedRed, $normalizedGreen, $normalizedBlue);
        $chroma = $maxRGB - $minRGB;
        $value = $maxRGB; // also called brightness
        if ($chroma == 0) {
            $hue = 0;
        } elseif ($maxRGB == $normalizedRed) {
            $hue = 60 * (($normalizedGreen - $normalizedBlue) / $chroma);
        } elseif ($maxRGB == $normalizedGreen) {
            $hue = 60 * (2 + ($normalizedBlue - $normalizedRed) / $chroma);
        } else {
            $hue = 60 * (4 + ($normalizedRed - $normalizedGreen) / $chroma);
        }

        if ($hue < 0) {
            $hue += 360;
        }
        return array($maxRGB, $minRGB, $chroma, $value, $hue);
    }

    private static function HSLToRGB(int $hue, float $saturation, float $lightness): array
    {
        $chroma = (1 - abs(2 * $lightness - 1)) * $saturation;
        $hueNormalized = $hue / 60;
        $hMod2 = $hueNormalized - 2 * floor($hueNormalized / 2);
        $intermediateValue = $chroma * (1 - abs($hMod2 - 1));

        if (0 <= $hueNormalized && $hueNormalized < 1) {
            list($r, $g, $b) = array($chroma, $intermediateValue, 0);
        } elseif (1 <= $hueNormalized && $hueNormalized < 2) {
            list($r, $g, $b) = array($intermediateValue, $chroma, 0);
        } elseif (2 <= $hueNormalized && $hueNormalized < 3) {
            list($r, $g, $b) = array(0, $chroma, $intermediateValue);
        } elseif (3 <= $hueNormalized && $hueNormalized < 4) {
            list($r, $g, $b) = array(0, $intermediateValue, $chroma);
        } elseif (4 <= $hueNormalized && $hueNormalized < 5) {
            list($r, $g, $b) = array($intermediateValue, 0, $chroma);
        } elseif (5 <= $hueNormalized && $hueNormalized < 6) {
            list($r, $g, $b) = array($chroma, 0, $intermediateValue);
        }
        if (!isset($r) || !isset($g) || !isset($b)) {
            throw new Exception('RGB calculation not possible. Check inputs!');
        }
        $m = $lightness - $chroma / 2;
        $r = intval(round(($r + $m) * 255));
        $g = intval(round(($g + $m) * 255));
        $b = intval(round(($b + $m) * 255));

        return array($r, $g, $b);
    }

    /**
     * @param  string  $color  hex color with leading #, e.g. #FF00FF
     * @return void
     */
    public function setHex(string $color): void
    {
        if (!preg_match("/#[0-9a-fA-F]{3}/", $color) &&
            !preg_match("/#[0-9a-fA-F]{6}/", $color)) {
            return;
        }
        $color = substr($color, 1);
        $this->hex = $color;

        $this->rgb = Color::HexToRGB($this->hex);
        $this->hsl = Color::RGBToHSL($this->rgb[0], $this->rgb[1], $this->rgb[2]);
    }

    public function setRGB(array $color): void
    {
        $this->rgb = $color;
        $this->hex = Color::RGBToHex($color[0], $color[1], $color[2]);
        $this->hsl = Color::RGBToHSL($color[0], $color[1], $color[2]);
    }

    public function setHSL(array $color): void
    {
        $this->hsl = $color;
        $this->rgb = $this->HSLToRGB($color[0], $color[1], $color[2]);
        $this->hex = $this->RGBToHex($this->rgb[0], $this->rgb[1], $this->rgb[2]);
    }

    /**
     * @return float[]|int[]
     */
    public function getHSL(): array
    {
        return $this->hsl;
    }

    /**
     * @return array|int[]
     */
    public function getRGB(): array
    {
        return $this->rgb;
    }

    /**
     * @return string
     */
    public function getHex(): string
    {
        return '#'.$this->hex;
    }

    public function getColorSet()
    {
        list($hue, $saturation, $lightness) = $this->hsl;
        if ($lightness <= 0.5) {
            $dark = new Color(ColorType::HSL, $this->hsl);
            $light = new Color(ColorType::HSL, $this->hsl);
            $light->brighten(50);
        } else {
            $dark = new Color(ColorType::HSL, $this->hsl);
            $light = new Color(ColorType::HSL, $this->hsl);
            $dark->darken(50);
        }
        return array($dark, $light);
    }

    public function brighten(int $amount = 10): void
    {
        list($hue, $saturation, $lightness) = $this->hsl;
        $lightness = self::clamp($lightness + $amount / 100, 0, 1);
        $this->setHSL(array($hue, $saturation, $lightness));
    }

    public function darken(int $amount = 10): void
    {
        list($hue, $saturation, $lightness) = $this->hsl;
        $lightness = self::clamp($lightness - $amount / 100, 0, 1);
        $this->setHSL(array($hue, $saturation, $lightness));
    }

    private static function clamp(int|float $num, int|float $min, int|float $max): int|float
    {
        if ($num > $max) {
            $num = $max;
        } elseif ($num < $min) {
            $num = $min;
        }
        return $num;
    }

}