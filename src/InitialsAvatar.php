<?php

namespace Renfordt\Larvatar;

use SVG\Nodes\Shapes\SVGCircle;
use SVG\Nodes\Texts\SVGText;
use SVG\SVG;

class InitialsAvatar
{
    private string $fontPath = '';
    private string $fontFamily = '';
    private array $names = [];
    private int $size = 128;

    /**
     * Create an instance of InitialsAvatar
     * @param  string  $name  First and last name or username, seperated by a space
     */
    public function __construct(string $name = '')
    {
        $this->setName($name);
    }

    /**
     * Generates the InitialsAvatar as an SVG
     * @param  array  $names  Array of Names which shall be shortend for the initials
     * @return string Returns a SVG code of the Initials
     */
    public function generate(array $names = []): string
    {
        if (empty($names)) {
            $names = $this->names;
        }
        $larvatar = new SVG($this->size, $this->size);
        $doc = $larvatar->getDocument();
        if ($this->fontPath != '' & $this->fontFamily != '') {
            SVG::addFont(__DIR__.$this->fontPath);
        }
        $halfSize = $this->size / 2;

        $circle = new SVGCircle($halfSize, $halfSize, $halfSize);
        $circle->setStyle('fill', $this->generateHexColor($names));

        $initials = '';
        foreach ($names as $name) {
            $initials .= substr($name, 0, 1);
        }

        $initials = new SVGText($initials, '50%', '55%');
        $initials->setStyle('fill', '#ffffff');
        $initials->setStyle('text-anchor', 'middle');
        $initials->setStyle('dominant-baseline', 'middle');
        $initials->setFontFamily($this->fontFamily);
        $initials->setFontSize($this->size * 0.5 .'px');

        $doc->addChild($circle);
        $doc->addChild($initials);

        return $larvatar;
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
     * Sets the names for the avatar
     * @param  string  $name  Names seperated by a space for generating the avatar
     * @return void
     */
    public function setName(string $name): void
    {
        $this->names = explode(' ', $name);
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

    /**
     * Generates a hex color code based on the names
     * @param  array|null  $names Array of names used to generate the hex color code.
     * @param  int  $offset Offset of the hash, similar to a seed
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
}
