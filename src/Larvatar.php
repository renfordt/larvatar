<?php

namespace Renfordt\Larvatar;

use SVG\Nodes\Shapes\SVGCircle;
use SVG\Nodes\Texts\SVGText;
use SVG\SVG;

class Larvatar
{
    public $size = 128;

    /*public function GetLarvatar(): string
    {

    }*/

    public function GenerateLarvatar(array $names): string
    {
        $larvatar = new SVG($this->size, $this->size);
        $doc = $larvatar->getDocument();
        $half_size = $this->size / 2;

        $circle = new SVGCircle($half_size, $half_size, $half_size);
        $circle->setStyle('fill', $this->GenerateHexColor($names));

        $initials = '';
        foreach ($names as $name) {
            $initials .= substr($name, 0, 1);
        }

        $initials_SVG = new SVGText($initials, '50%', '55%');
        $initials_SVG->setStyle('fill', '#ffffff');
        $initials_SVG->setStyle('text-anchor', 'middle');
        $initials_SVG->setStyle('dominant-baseline', 'middle');
        //$initials_SVG->setFontFamily('Roboto');
        $initials_SVG->setFontSize($this->size * 0.6);

        $doc->addChild($circle);
        $doc->addChild($initials_SVG);

        return $larvatar;

    }

    protected function GenerateHexColor(array $names, $offset = 0): string
    {
        $name = implode(' ', $names);
        $hash = md5($name);
        return '#'.substr($hash, $offset, 6);
    }

}