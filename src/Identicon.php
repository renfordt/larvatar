<?php

namespace Renfordt\Larvatar;

use Renfordt\Larvatar\Enum\ColorType;
use SVG\Nodes\Shapes\SVGRect;
use SVG\SVG;

class Identicon
{
    public string $name;
    public int $size = 125;
    public int $pixels = 5;
    public $hash;

    private float $backgroundLightness = 0.8;
    private float $textLightness = 0.35;
    private bool $symmetry;

    public function __construct(string $name, bool $symmetry = true, int $size = 125, int $pixels = 5)
    {
        $this->name = $name;
        $this->size = $size;
        $this->pixels = $pixels;
        $this->symmetry = $symmetry;
        $this->hash = $this->generateHash();
    }

    public function generateHash(): string
    {
        return md5($this->name);
    }

    public function getSVG(): string
    {
        $larvatar = new SVG($this->size, $this->size);
        $doc = $larvatar->getDocument();

        $color = $this->getColor();
        list($darkColor, $lightColor) = $color->getColorSet($this->textLightness, $this->backgroundLightness);

        if ($this->symmetry) {
            $matrix = $this->generateSymmetricMatrix();
        } else {
            $matrix = $this->generateMatrix();
        }

        foreach ($matrix as $y => $array) {
            foreach ($array as $x => $value) {
                if ($value == true) {
                    $square = new SVGRect(
                        (int) $x * ($this->size / $this->pixels),
                        (int) $y * ($this->size / $this->pixels),
                        (int) $this->size / $this->pixels,
                        (int) $this->size / $this->pixels);
                    $square->setStyle('fill', $darkColor->getHex());
                    $doc->addChild($square);
                }
            }

        }

        return $larvatar;
    }

    private function getColor(): Color
    {
        return new Color(ColorType::Hex, $this->generateHexColor());
    }

    public function generateHexColor(array $names = null, int $offset = 0): string
    {
        if ($names == null) {
            $names = $this->name;
        }
        //$name = implode(' ', $names);
        return '#'.substr($this->hash, $offset, 6);
    }

    /**
     * Generate a symmetric identicon matrix based on the provided hash
     *
     * @return array The generated symmetric matrix
     */
    public function generateSymmetricMatrix(): array
    {
        preg_match_all('/(\w)(\w)/', $this->hash, $chars);
        $symmetryMatrix = $this->getSymmetryMatrix();
        $divider = count($symmetryMatrix);

        for ($i = 0; $i < pow($this->pixels, 2); $i++) {
            $index = (int) ($i / 3);
            $data = $this->convertStrToBool(substr($this->hash, $i, 1));

            foreach ($symmetryMatrix[$i % $divider] as $item) {
                $matrix[$index][$item] = $data;
            }
        }

        return $matrix;
    }

    /**
     * Returns the symmetry matrix.
     *
     * @return array The symmetry matrix.
     */
    private function getSymmetryMatrix(): array
    {
        $items = [];
        $i = $this->pixels - 1;
        for ($x = 0; $x <= $i / 2; $x++) {
            $items[$x] = [$x];
            if ($x !== $i - $x) {
                $items[$x][] = $i - $x;
            }
        }
        return $items;
    }

    /**
     * Converts a hexadecimal character to a boolean value.
     *
     * @param  string  $char  The hexadecimal character to convert.
     * @return bool The boolean value converted from the hexadecimal character.
     */
    private function convertStrToBool(string $char): bool
    {
        return (bool) round(hexdec($char) / 10);
    }

    /**
     * Generates a matrix based on the given offset value.
     *
     * @param  int  $offset  The offset value for generating the matrix. Defaults to 0.
     * @return array The generated matrix.
     */
    public function generateMatrix(int $offset = 0): array
    {
        $column = 0;
        $row = 0;
        for ($i = 0; $i < pow($this->pixels, 2); $i++) {
            $matrix[$i % $this->pixels][floor($i / $this->pixels)] =
                $this->convertStrToBool(substr($this->hash, $i, 1));
            if ($column == $this->pixels && $row < $this->pixels) {
                $row++;
                $column = -1;
            }
            if ($column < $this->pixels) {
                $column++;
            }
        }

        return $matrix;
    }

}

