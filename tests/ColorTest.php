<?php


use Renfordt\Larvatar\Color;
use PHPUnit\Framework\TestCase;
use Renfordt\Larvatar\Enum\ColorType;

class ColorTest extends TestCase
{

    public function testGetRGB()
    {
        $color = new Color(ColorType::RGB, array(255, 255, 255));
        $this->assertEquals(array(255, 255, 255), $color->getRGB());

        $color = new Color(ColorType::Hex, '#78b649');
        $this->assertEquals(array(120, 182, 73), $color->getRGB());

        $color = new Color(ColorType::HSL, array(273, 0.87, 0.34));
        $this->assertEquals(array(94, 11, 162), $color->getRGB());


    }

    public function testGetHSL()
    {
        $color = new Color(ColorType::RGB, array(152, 184, 71));
        $this->assertEquals(array(77, 0.44, 0.50), $color->getHSL());

        $color = new Color(ColorType::Hex, '#1f8986');
        $this->assertEquals(array(178, 0.63, 0.33), $color->getHSL());

        $color = new Color(ColorType::HSL, array(302, 0.81, 0.64));
        $this->assertEquals(array(302, 0.81, 0.64), $color->getHSL());
    }

    public function testGetHex()
    {
        $color = new Color(ColorType::RGB, array(23, 47, 134));
        $this->assertEquals('#172f86', $color->getHex());

        $color = new Color(ColorType::Hex, '#b364b2');
        $this->assertEquals('#b364b2', $color->getHex());

        $color = new Color(ColorType::HSL, array(26, 0.90, 0.45));
        $this->assertEquals('#da650b', $color->getHex());
    }
}
