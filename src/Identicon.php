<?php

namespace Renfordt\Larvatar;

use Renfordt\Colors\HSLColor;
use Renfordt\Larvatar\Traits\ColorTrait;
use SVG\Nodes\Shapes\SVGRect;
use SVG\SVG;

class Identicon extends Avatar
{
    use ColorTrait;

    public int $pixels = 5;
    private bool $symmetry = true;

    public function __construct(Name $name)
    {
        $this->name = $name;
    }

    public static function make(Name $name): Identicon
    {
        return new static($name);
    }

    /**
     * Sets the number of pixels.
     *
     * @param int $pixels The number of pixels to set.
     * @return void
     */
    public function setPixels(int $pixels): void
    {
        $this->pixels = $pixels;
    }

    /**
     * Sets the symmetry property of the object.
     *
     * @param bool $symmetry The symmetry value to set.
     * @return void
     */
    public function setSymmetry(bool $symmetry): void
    {
        $this->symmetry = $symmetry;
    }

    /**
     * Returns the HTML representation of the image.
     *
     * @param bool $base64 Determines whether the HTML representation should be in base64 format or not.
     * @return string The HTML representation of the image.
     */
    public function getHTML(bool $base64 = false): string
    {
        if (!$base64) {
            return $this->getSVG();
        }

        return '<img src="' . $this->getBase64() . '" />';
    }

    /**
     * Returns the SVG representation of the Identicon .
     *
     * @return string The SVG representation of the Identicon.
     */
    public function getSVG(): string
    {
        $larvatar = new SVG($this->size, $this->size);
        $doc = $larvatar->getDocument();

        $color = $this->getHSLColor(
            $this->name
        );

        if ($this->symmetry) {
            $matrix = $this->generateSymmetricMatrix();
        } else {
            $matrix = $this->generateMatrix();
        }

        foreach ($matrix as $y => $array) {
            foreach ($array as $x => $value) {
                if ($value) {
                    $square = new SVGRect(
                        (int)$x * ($this->size / $this->pixels),
                        (int)$y * ($this->size / $this->pixels),
                        (int)$this->size / $this->pixels,
                        (int)$this->size / $this->pixels
                    );
                    $square->setStyle('fill', $color->toHex());
                    $doc->addChild($square);
                }
            }
        }

        return $larvatar;
    }

    /**
     * Generate a symmetric identicon matrix based on the provided hash
     *
     * @return array The generated symmetric matrix
     */
    public function generateSymmetricMatrix(): array
    {
        preg_match_all('/(\w)(\w)/', $this->name->getHash(), $chars);
        $symmetryMatrix = $this->getSymmetryMatrix();
        $divider = count($symmetryMatrix);

        for ($i = 0; $i < pow($this->pixels, 2); $i++) {
            $index = (int)($i / 3);
            $data = $this->convertStrToBool(substr($this->name->getHash(), $i, 1));

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
     * @param string $char The hexadecimal character to convert.
     * @return bool The boolean value converted from the hexadecimal character.
     */
    private function convertStrToBool(string $char): bool
    {
        return (bool)round(hexdec($char) / 10);
    }

    /**
     * Generates a matrix based on the given offset value.
     *
     * @param int $offset The offset value for generating the matrix. Defaults to 0.
     * @return array The generated matrix.
     */
    private function generateMatrix(int $offset = 0): array
    {
        $column = 0;
        $row = 0;
        $hash = hash('sha256', $this->name->getHash());
        for ($i = 0; $i < pow($this->pixels, 2); $i++) {
            $matrix[$i % $this->pixels][floor($i / $this->pixels)] =
                $this->convertStrToBool(substr($hash, $i, 1));
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

    /**
     * Returns the base64 representation of the SVG image.
     *
     * @return string The base64 encoded string representing the SVG image.
     */
    public function getBase64(): string
    {
        return 'data:image/svg+xml;base64,' . base64_encode($this->getSVG());
    }
}
