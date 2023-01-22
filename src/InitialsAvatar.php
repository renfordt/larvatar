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

    public function __construct(string $name = '')
    {
        $this->setName($name);
    }

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

    public function setSize(int $size): void
    {
        $this->size = $size;
    }

    public function setName(string $name): void
    {
        $this->names = explode(' ', $name);
    }

    public function setFont(string $fontFamily, string $path): void
    {
        $this->fontFamily = $fontFamily;
        $this->fontPath = $path;
    }

    public function generateHexColor(array $names = null, $offset = 0): string
    {
        if ($names == null) {
            $names = $this->names;
        }
        $name = implode(' ', $names);
        $hash = md5($name);
        return '#'.substr($hash, $offset, 6);
    }
}
