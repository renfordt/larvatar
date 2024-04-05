<?php

namespace Renfordt\Larvatar;

use Renfordt\Larvatar\Enum\ColorType;
use SVG\Nodes\Shapes\SVGCircle;
use SVG\Nodes\Texts\SVGText;
use SVG\SVG;

class InitialsAvatar
{
    private string $fontPath = '';
    private string $fontFamily = '';
    private array $names = [];
    private int $size = 128;
    private int $fontSize = 0;

    /**
     * Create an instance of InitialsAvatar
     * @param  string  $name  First and last name or username, seperated by a space
     */
    public function __construct(string $name = '')
    {
        $this->setName($name);
    }

    /**
     * Sets the names for the avatar
     * @param  string  $name  Names seperated by a space for generating the avatar
     * @return void
     */
    public function setName(string $name): void
    {
        $this->names = explode(' ', $name);
    }

    /**
     * Generates the InitialsAvatar as an SVG
     * @param  array  $names  Array of Names which shall be shortend for the initials
     * @return string Returns a SVG code of the Initials
     */
    public function generate(array $names = [], string|null $encoding = null): string
    {
        $names = $this->getNames($names);
        $larvatar = new SVG($this->size, $this->size);
        $doc = $larvatar->getDocument();

        $this->addFontIfNotEmpty();
        $halfSize = $this->size / 2;

        $color = $this->getColor($names);
        list($darkColor, $lightColor) = $color->getColorSet();

        $circle = $this->getCircle($halfSize, $lightColor);
        $initials = $this->getInitials($names, $darkColor);

        $doc->addChild($circle);
        $doc->addChild($initials);

        if ($encoding == 'base64') {
            return 'data:image/svg+xml;base64,'.base64_encode($larvatar);
        }
        return $larvatar;
    }

    /**
     * Retrieves the names array
     * If the provided $names array is empty,
     * it returns the default names array
     *
     * @param  array  $names  The names array
     * @return array  The names array to be returned
     */
    private function getNames(array $names): array
    {
        return empty($names) ? $this->names : $names;
    }

    /**
     * Adds a font if the font path and font family are not empty
     * @return void
     */
    private function addFontIfNotEmpty(): void
    {
        if ($this->fontPath != '' && $this->fontFamily != '') {
            SVG::addFont(__DIR__.$this->fontPath);
        }
    }

    /**
     * Retrieves the color based on the given array of names
     *
     * @param  array  $names  An array of names
     * @return Color  The color object with the generated hex color
     */
    private function getColor(array $names): Color
    {
        return new Color(ColorType::Hex, $this->generateHexColor($names));
    }

    /**
     * Generates a hex color code based on the names
     * @param  array|null  $names  Array of names used to generate the hex color code.
     * @param  int  $offset  Offset of the hash, similar to a seed
     * @return string Returns a color hash code, e.g. '#123456'
     */
    public function generateHexColor(array $names = null, int $offset = 0): string
    {
        if ($names == null) {
            $names = $this->names;
        }
        $name = implode(' ', $names);
        $hash = md5($name);
        return '#'.substr($hash, $offset, 6);
    }

    /**
     * Get a circle SVG element
     *
     * @param  float  $halfSize  Half of the size of the circle
     * @param  Color  $lightColor  The light color to fill the circle with
     * @return  SVGCircle                     The circle SVG element
     */
    private function getCircle(float $halfSize, Color $lightColor): SVGCircle
    {
        $circle = new SVGCircle($halfSize, $halfSize, $halfSize);
        $circle->setStyle('fill', $lightColor->getHex());

        return $circle;
    }

    /**
     * Generates initials for the given names and returns SVGText object
     * @param  array  $names  List of names
     * @param  Color  $darkColor  Dark color object
     * @return SVGText  SVGText object containing the initials
     */
    private function getInitials(array $names, Color $darkColor): SVGText
    {
        $initialsText = '';
        foreach ($names as $name) {
            $initialsText .= substr($name, 0, 1);
        }

        $initials = new SVGText($initialsText, '50%', '55%');
        $initials->setStyle('fill', $darkColor->getHex());
        $initials->setStyle('text-anchor', 'middle');
        $initials->setStyle('dominant-baseline', 'middle');
        $initials->setFontFamily($this->fontFamily);
        if ($this->fontSize == 0) {
            $this->fontSize = $this->calculateFontSize($initialsText);
        }
        $initials->setFontSize($this->fontSize.'px');

        return $initials;
    }

    /**
     * Calculate the font size based on the initials length
     *
     * @param  string  $initials  The initials to calculate the font size for
     * @return int  The calculated font size
     */
    protected function calculateFontSize(string $initials): int
    {
        return intval($this->size * (0.5 - sin(0.5 * strlen($initials) - 1) / 5));
    }

    /**
     * Sets the font size for the text
     *
     * @param  int  $size  The font size in pixel
     * @return void
     */
    public function setFontSize(int $size): void
    {
        $this->fontSize = $size;
    }

    /**
     * Sets the size of the avatar
     * @param  int  $size  Size in pixel
     * @return void
     */
    public function setSize(int $size): void
    {
        $this->size = $size;
    }

    /**
     * Sets the font which shall be used for the avatar
     * @param  string  $fontFamily  Font Family, e.g. 'Roboto'
     * @param  string  $path  Relative path to the true type font with a leading slash, e.g. '/font/Roboto-Bold.ttf'
     * @return void
     */
    public function setFont(string $fontFamily, string $path): void
    {
        $this->fontFamily = $fontFamily;
        $this->fontPath = $path;
    }
}
