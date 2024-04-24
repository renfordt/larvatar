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

    public static function make(ColorType $type, array|string $color): Color
    {
        return new Color($type, $color);
    }

    /**
     * Converts a hexadecimal color code to RGB color
     * @param  string  $hexStr  Hexadecimal color code, with or without '#'
     * @return array|int[] Array of red, green, and blue values [0..255]
     * @throws InvalidArgumentException if the provided hex code is invalid
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
     * Convert RGB color to HSL color space.
     *
     * @param  int  $red  The red component of the RGB color (0-255).
     * @param  int  $green  The green component of the RGB color (0-255).
     * @param  int  $blue  The blue component of the RGB color (0-255).
     * @return array An array containing the HSL color values (hue, saturation, lightness).
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
     * Calculate the components Chroma, Value, and Hue based on RGB color.
     *
     * @param  int  $red  The red component of the RGB color (0-255).
     * @param  int  $green  The green component of the RGB color (0-255).
     * @param  int  $blue  The blue component of the RGB color (0-255).
     * @return array An array containing the calculated values (maxRGB, minRGB, chroma, value, hue).
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

    /**
     * Convert RGB color to HSV color space.
     *
     * @param  int  $red  The red component of the RGB color (0-255).
     * @param  int  $green  The green component of the RGB color (0-255).
     * @param  int  $blue  The blue component of the RGB color (0-255).
     * @return array An array containing the HSV color values (hue, saturation, value).
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
     * Convert HSV color to RGB color space.
     *
     * @param  int  $hue  The hue component of the HSV color (0-360).
     * @param  float  $saturation  The saturation component of the HSV color (0-1).
     * @param  float  $value  The value component of the HSV color (0-1).
     * @return array An array containing the RGB color values (red, green, blue).
     * @throws InvalidArgumentException if any of the parameters exceed their intended ranges.
     * @throws Exception if RGB calculation is not possible.
     */
    public static function HSVToRGB(int $hue, float $saturation, float $value): array
    {
        self::validateParameters($hue, $saturation, $value);

        $chroma = $value * $saturation;
        $hueNormalized = $hue / 60;
        $hMod2 = $hueNormalized - 2 * floor($hueNormalized / 2);
        $secondMax = $chroma * (1 - abs($hMod2 - 1));

        list($red, $green, $blue) = self::calculateRGBRange($hueNormalized, $chroma, $secondMax);

        return self::finalizeRGBCalculation($red, $green, $blue, $value, $chroma);
    }

    private static function validateParameters(int $hue, float $saturation, float $value): void
    {
        if ($hue < 0 || $hue > 360 ||
            $saturation < 0 || $saturation > 1 ||
            $value < 0 || $value > 1) {
            throw new InvalidArgumentException('Parameters exceed their intended ranges.');
        }
    }

    /**
     * Calculate the RGB range based on the normalized hue value.
     *
     * @param  float  $hueNormalized  The normalized hue value (0-6).
     * @param  float  $chroma  The chroma value (0 - 360).
     * @param  float  $secondMax  The second maximum value.
     * @return array An array containing the RGB color values.
     */
    private static function calculateRGBRange(float $hueNormalized, float $chroma, float $secondMax): array
    {
        if (0 <= $hueNormalized && $hueNormalized < 1) {
            return [$chroma, $secondMax, 0];
        } elseif (1 <= $hueNormalized && $hueNormalized < 2) {
            return [$secondMax, $chroma, 0];
        } elseif (2 <= $hueNormalized && $hueNormalized < 3) {
            return [0, $chroma, $secondMax];
        } elseif (3 <= $hueNormalized && $hueNormalized < 4) {
            return [0, $secondMax, $chroma];
        } elseif (4 <= $hueNormalized && $hueNormalized < 5) {
            return [$secondMax, 0, $chroma];
        } elseif (5 <= $hueNormalized && $hueNormalized < 6) {
            return [$chroma, 0, $secondMax];
        } else {
            return [];
        }
    }

    /**
     * Finalize the RGB color calculation based on the given parameters.
     *
     * @param  float  $red  The red component of the RGB color (0-255).
     * @param  float  $green  The green component of the RGB color (0-255).
     * @param  float  $blue  The blue component of the RGB color (0-255).
     * @param  float  $value  The value component of the RGB color (0-1).
     * @param  float  $chroma  The chroma component of the RGB color (0-1).
     * @param  bool  $isLightness  Flag indicating if the calculation is for lightness.
     * @return array An array containing the finalized RGB color values (red, green, blue).
     */
    private static function finalizeRGBCalculation(
        float $red,
        float $green,
        float $blue,
        float $value,
        float $chroma,
        bool $isLightness = false
    ): array {
        $m = $isLightness ? $value - $chroma / 2 : $value - $chroma;

        return array_map(fn($color) => intval(round(($color + $m) * 255)), [$red, $green, $blue]);
    }

    /**
     * Convert RGB color to hexadecimal color representation.
     *
     * @param  int  $red  The red component of the RGB color (0-255).
     * @param  int  $green  The green component of the RGB color (0-255).
     * @param  int  $blue  The blue component of the RGB color (0-255).
     * @return string The hexadecimal representation of the RGB color.
     */
    public static function RGBToHex(int $red, int $green, int $blue): string
    {
        $hexr = str_pad(dechex($red), 2, "0", STR_PAD_LEFT);
        $hexg = str_pad(dechex($green), 2, "0", STR_PAD_LEFT);
        $hexb = str_pad(dechex($blue), 2, "0", STR_PAD_LEFT);
        return $hexr.$hexg.$hexb;
    }

    /**
     * Convert HSL color to RGB color space.
     *
     * @param  int  $hue  The hue component of the HSL color (0-359).
     * @param  float  $saturation  The saturation component of the HSL color (0-1).
     * @param  float  $lightness  The lightness component of the HSL color (0-1).
     * @return array An array containing the RGB color values (red, green, blue).
     * @throws Exception If RGB calculation is not possible.
     */
    private static function HSLToRGB(int $hue, float $saturation, float $lightness): array
    {
        $chroma = (1 - abs(2 * $lightness - 1)) * $saturation;
        $hueNormalized = $hue / 60;
        $hMod2 = $hueNormalized - 2 * floor($hueNormalized / 2);
        $intermediateValue = $chroma * (1 - abs($hMod2 - 1));

        list($red, $green, $blue) = self::calculateRGBRange($hueNormalized, $chroma, $intermediateValue);

        if (!isset($red) || !isset($green) || !isset($blue)) {
            throw new Exception('RGB calculation not possible. Check inputs!');
        }

        return self::finalizeRGBCalculation($red, $green, $blue, $lightness, $chroma, true);
    }

    /**
     * Get the HSL color values of the current object.
     *
     * @return array An array containing the HSL color values (hue, saturation, lightness).
     */
    public function getHSL(): array
    {
        return $this->hsl;
    }

    /**
     * Set the HSL color values and update the RGB and hex color values.
     *
     * @param  array  $color  An array containing the HSL color values (hue, saturation, lightness).
     * @return void
     */
    public function setHSL(array $color): void
    {
        $this->hsl = $color;
        $this->rgb = $this->HSLToRGB($color[0], $color[1], $color[2]);
        $this->hex = $this->RGBToHex($this->rgb[0], $this->rgb[1], $this->rgb[2]);
    }

    /**
     * Get the RGB color values.
     *
     * @return array An array containing the RGB color values (red, green, blue).
     */
    public function getRGB(): array
    {
        return $this->rgb;
    }

    /**
     * Set the RGB color.
     *
     * @param  array  $color  An array containing the RGB color values (red, green, blue).
     * @return void
     */
    public function setRGB(array $color): void
    {
        $this->rgb = $color;
        $this->hex = Color::RGBToHex($color[0], $color[1], $color[2]);
        $this->hsl = Color::RGBToHSL($color[0], $color[1], $color[2]);
    }

    /**
     * Get the hexadecimal representation of the color.
     *
     * @return string The hexadecimal string representation of the color.
     */
    public function getHex(): string
    {
        return '#'.$this->hex;
    }

    /**
     * Set the hexadecimal color value.
     *
     * @param  string  $color  The hexadecimal color value.
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

    /**
     * Get a color set based on the HSL color.
     *
     * @param  float  $darkLightness  The lightness value for the dark color (0.0-1.0).
     * @param  float  $lightLightness  The lightness value for the light color (0.0-1.0).
     * @return array An array containing the dark and light color.
     */
    public function getColorSet(float $darkLightness = 0.35, float $lightLightness = 0.8): array
    {
        list($hue, $saturation, $lightness) = $this->hsl;

        $dark = new Color(ColorType::HSL, [$hue, $saturation, $darkLightness]);
        $light = new Color(ColorType::HSL, [$hue, $saturation, $lightLightness]);
        return array($dark, $light);
    }

    /**
     * Brighten the color by a specified amount.
     *
     * @param  int  $amount  The amount to brighten the color by as a percentage (default: 10).
     * @return void
     */
    public function brighten(int $amount = 10): void
    {
        list($hue, $saturation, $lightness) = $this->hsl;
        $lightness = clamp($lightness + $amount / 100, 0, 1);
        $this->setHSL(array($hue, $saturation, $lightness));
    }

    /**
     * Clamp a number between a minimum and maximum value.
     *
     * @param  int|float  $num  The number to clamp.
     * @param  int|float  $min  The minimum value.
     * @param  int|float  $max  The maximum value.
     * @return int|float  The clamped number.
     * @deprecated v1.4.0
     */
    private static function clamp(int|float $num, int|float $min, int|float $max): int|float
    {
        return clamp($num, $min, $max);
    }

    /**
     * Darken the color by reducing its lightness value.
     *
     * @param  int  $amount  The amount by which to darken the color (0-100).
     * @return void
     */
    public function darken(int $amount = 10): void
    {
        list($hue, $saturation, $lightness) = $this->hsl;
        $lightness = clamp($lightness - $amount / 100, 0, 1);
        $this->setHSL(array($hue, $saturation, $lightness));
    }
}
