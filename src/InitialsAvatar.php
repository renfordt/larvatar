<?php

namespace Renfordt\Larvatar;

use SVG\Nodes\Shapes\SVGCircle;
use SVG\Nodes\Texts\SVGText;
use SVG\SVG;

class InitialsAvatar
{
    private string $font_path = '';
    private string $font_family = '';
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
        if ($this->font_path != '' & $this->font_family != '') {
            SVG::addFont(__DIR__.'/'.$this->font_path);
        }
        $half_size = $this->size / 2;

        $circle = new SVGCircle($half_size, $half_size, $half_size);
        $circle->setStyle('fill', $this->generateHexColor($names));

        $initials = '';
        foreach ($names as $name) {
            $initials .= substr($name, 0, 1);
        }

        $initials_SVG = new SVGText($initials, '50%', '55%');
        $initials_SVG->setStyle('fill', '#ffffff');
        $initials_SVG->setStyle('text-anchor', 'middle');
        $initials_SVG->setStyle('dominant-baseline', 'middle');
        $initials_SVG->setFontFamily($this->font_family);
        $initials_SVG->setFontSize($this->size * 0.5);

        $doc->addChild($circle);
        $doc->addChild($initials_SVG);

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

    public function setFont(string $font_family, string $path): void
    {
        $this->font_family = $font_family;
        $this->font_path = $path;
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