<?php

use Renfordt\Larvatar\Color;
use PHPUnit\Framework\TestCase;
use Renfordt\Larvatar\Enum\ColorType;

/**
 * Class ColorTest
 *
 * Tests for methods in the Color class.
 */
class ColorTest extends TestCase
{
    /**
     * Tests the HexToRGB method.
     *
     * @throws \Exception
     */
    public function testHexToRGB(): void
    {
        $hexColor = '#ffffff';
        $expectedResult = [255, 255, 255];

        $actualResult = Color::HexToRGB($hexColor);

        $this->assertEquals($expectedResult, $actualResult);

        $hexColor = '#000000';
        $expectedResult = [0, 0, 0];

        $actualResult = Color::HexToRGB($hexColor);

        $this->assertEquals($expectedResult, $actualResult);
    }

    /**
     * Tests the RGBToHSL method with a variety of colors.
     *
     * @throws \Exception
     */
    public function testRGBToHSL(): void
    {
        // Test case 1: White
        $rgbColor = [255, 255, 255];
        $expectedResult = [0, 0, 1];
        $actualResult = Color::RGBToHSL($rgbColor[0], $rgbColor[1], $rgbColor[2]);
        $this->assertEquals($expectedResult, $actualResult);

        // Test case 2: Black
        $rgbColor = [0, 0, 0];
        $expectedResult = [0, 0, 0];
        $actualResult = Color::RGBToHSL($rgbColor[0], $rgbColor[1], $rgbColor[2]);
        $this->assertEquals($expectedResult, $actualResult);

        // Test case 3: Red
        $rgbColor = [255, 0, 0];
        $expectedResult = [0, 1, 0.5];
        $actualResult = Color::RGBToHSL($rgbColor[0], $rgbColor[1], $rgbColor[2]);
        $this->assertEquals($expectedResult, $actualResult);

        // Test case 4: Green
        $rgbColor = [0, 255, 0];
        $expectedResult = [120, 1, 0.5];
        $actualResult = Color::RGBToHSL($rgbColor[0], $rgbColor[1], $rgbColor[2]);
        $this->assertEquals($expectedResult, $actualResult);

        // Test case 5: Blue
        $rgbColor = [0, 0, 255];
        $expectedResult = [240, 1, 0.5];
        $actualResult = Color::RGBToHSL($rgbColor[0], $rgbColor[1], $rgbColor[2]);
        $this->assertEquals($expectedResult, $actualResult);
    }

    /**
     * Tests the RGBToHSV method with a variety of colors.
     *
     * @throws \Exception
     */
    public function testRGBToHSV(): void
    {
        // Test case 1: White
        $rgbColor = [255, 255, 255];
        $expectedResult = [0, 0, 1];
        $actualResult = Color::RGBToHSV($rgbColor[0], $rgbColor[1], $rgbColor[2]);
        $this->assertEquals($expectedResult, $actualResult, 'Case 1 failed: White');

        // Test case 2: Black
        $rgbColor = [0, 0, 0];
        $expectedResult = [0, 0, 0];
        $actualResult = Color::RGBToHSV($rgbColor[0], $rgbColor[1], $rgbColor[2]);
        $this->assertEquals($expectedResult, $actualResult, 'Case 2 failed: Black');

        // Test case 3: Red
        $rgbColor = [255, 0, 0];
        $expectedResult = [0, 100, 1];
        $actualResult = Color::RGBToHSV($rgbColor[0], $rgbColor[1], $rgbColor[2]);
        $this->assertEquals($expectedResult, $actualResult, 'Case 3 failed: Red');

        // Test case 4: Green
        $rgbColor = [0, 255, 0];
        $expectedResult = [120, 100, 1];
        $actualResult = Color::RGBToHSV($rgbColor[0], $rgbColor[1], $rgbColor[2]);
        $this->assertEquals($expectedResult, $actualResult, 'Case 4 failed: Green');

        // Test case 5: Blue
        $rgbColor = [0, 0, 255];
        $expectedResult = [240, 100, 1];
        $actualResult = Color::RGBToHSV($rgbColor[0], $rgbColor[1], $rgbColor[2]);
        $this->assertEquals($expectedResult, $actualResult, 'Case 5 failed: Blue');
    }

    /**
     * Tests the RGBToHex method.
     *
     * @throws \Exception
     */
    public function testRGBToHex(): void
    {
        // Test case 1: White
        $rgbColor = [255, 255, 255];
        $expectedResult = 'ffffff';
        $actualResult = Color::RGBToHex($rgbColor[0], $rgbColor[1], $rgbColor[2]);
        $this->assertEquals($expectedResult, $actualResult, 'Case 1 failed: White');

        // Test case 2: Black
        $rgbColor = [0, 0, 0];
        $expectedResult = '000000';
        $actualResult = Color::RGBToHex($rgbColor[0], $rgbColor[1], $rgbColor[2]);
        $this->assertEquals($expectedResult, $actualResult, 'Case 2 failed: Black');

        // Test case 3: Red
        $rgbColor = [255, 0, 0];
        $expectedResult = 'ff0000';
        $actualResult = Color::RGBToHex($rgbColor[0], $rgbColor[1], $rgbColor[2]);
        $this->assertEquals($expectedResult, $actualResult, 'Case 3 failed: Red');

        // Test case 4: Green
        $rgbColor = [0, 255, 0];
        $expectedResult = '00ff00';
        $actualResult = Color::RGBToHex($rgbColor[0], $rgbColor[1], $rgbColor[2]);
        $this->assertEquals($expectedResult, $actualResult, 'Case 4 failed: Green');

        // Test case 5: Blue
        $rgbColor = [0, 0, 255];
        $expectedResult = '0000ff';
        $actualResult = Color::RGBToHex($rgbColor[0], $rgbColor[1], $rgbColor[2]);
        $this->assertEquals($expectedResult, $actualResult, 'Case 5 failed: Blue');

    }

    /**
     * Tests the HSVToRGB method.
     *
     * @throws \Exception
     */
    public function testHSVToRGB(): void
    {
        // Test case 1: White
        $HSVColor = [0, 0, 1];
        $expectedResult = [255, 255, 255];
        $actualResult = Color::HSVToRGB($HSVColor[0], $HSVColor[1], $HSVColor[2]);
        $this->assertEquals($expectedResult, $actualResult, 'Case 1 failed: White');

        // Test case 2: Black
        $HSVColor = [0, 0, 0];
        $expectedResult = [0, 0, 0];
        $actualResult = Color::HSVToRGB($HSVColor[0], $HSVColor[1], $HSVColor[2]);
        $this->assertEquals($expectedResult, $actualResult, 'Case 2 failed: Black');

        // Test case 3: Red
        $HSVColor = [0, 1, 1];
        $expectedResult = [255, 0, 0];
        $actualResult = Color::HSVToRGB($HSVColor[0], $HSVColor[1], $HSVColor[2]);
        $this->assertEquals($expectedResult, $actualResult, 'Case 3 failed: Red');

        // Test case 4: Green
        $HSVColor = [120, 1, 1];
        $expectedResult = [0, 255, 0];
        $actualResult = Color::HSVToRGB($HSVColor[0], $HSVColor[1], $HSVColor[2]);
        $this->assertEquals($expectedResult, $actualResult, 'Case 4 failed: Green');

        // Test case 5: Blue
        $HSVColor = [240, 1, 1];
        $expectedResult = [0, 0, 255];
        $actualResult = Color::HSVToRGB($HSVColor[0], $HSVColor[1], $HSVColor[2]);
        $this->assertEquals($expectedResult, $actualResult, 'Case 5 failed: Blue');
    }

    /**
     * Tests the calculateCVH method.
     *
     * @throws \Exception
     */
    public function testCalculateCVH(): void
    {
        // Test case 1: RGB (255, 255, 255)
        $expectedResult = [1.0, 1.0, 0, 1.0, 0];
        $actualResult = Color::calculateCVH(255, 255, 255);
        $this->assertEquals($expectedResult, $actualResult, 'Case 1 failed: White');

        // Test case 2: RGB (0, 0, 0)
        $expectedResult = [0, 0, 0, 0, 0];
        $actualResult = Color::calculateCVH(0, 0, 0);
        $this->assertEquals($expectedResult, $actualResult, 'Case 2 failed: Black');

        // Test case 3: RGB (255, 0, 0)
        $expectedResult = [1.0, 0, 1.0, 1.0, 0];
        $actualResult = Color::calculateCVH(255, 0, 0);
        $this->assertEquals($expectedResult, $actualResult, 'Case 3 failed: Red');

        // Test case 4: RGB (0, 255, 0)
        $expectedResult = [1.0, 0, 1.0, 1.0, 120];
        $actualResult = Color::calculateCVH(0, 255, 0);
        $this->assertEquals($expectedResult, $actualResult, 'Case 4 failed: Green');

        // Test case 5: RGB (0, 0, 255)
        $expectedResult = [0, 0, 1.0, 1.0, 240];
        $actualResult = Color::calculateCVH(0, 0, 255);
        $this->assertEquals($expectedResult, $actualResult, 'Case 5 failed: Blue');
    }

    /**
     * Tests the setHex method in different scenarios.
     *
     * @return void
     */
    public function testSetHex(): void
    {
        $color = new Color(ColorType::RGB, [255, 255, 255]);

        $color->setHex('#000000');
        $this->assertEquals([0, 0, 0], $color->getRGB());
        $this->assertEquals('#000000', $color->getHex());
        $this->assertEquals([0, 0, 0], $color->getHSL());

        $color->setHex('#FF0000');
        $this->assertEquals([255, 0, 0], $color->getRGB());
        $this->assertEquals('#FF0000', $color->getHex());
        $this->assertEquals([0, 1, 0.5], $color->getHSL());

        $color->setHex('#00FF00');
        $this->assertEquals([0, 255, 0], $color->getRGB());
        $this->assertEquals('#00FF00', $color->getHex());
        $this->assertEquals([120, 1, 0.5], $color->getHSL());

        $color->setHex('#0000FF');
        $this->assertEquals([0, 0, 255], $color->getRGB());
        $this->assertEquals('#0000FF', $color->getHex());
        $this->assertEquals([240, 1, 0.5], $color->getHSL());
    }

    /**
     * Tests the setRGB method in different scenarios.
     *
     * @return void
     */
    public function testSetRGB(): void
    {
        $color = new Color(ColorType::Hex, '#ffffff');

        $color->setRGB([0, 0, 0]);
        $this->assertEquals([0, 0, 0], $color->getRGB());
        $this->assertEquals([0, 0, 0], $color->getHSL());
        $this->assertEquals('#000000', $color->getHex());

        $color->setRGB([255, 0, 0]);
        $this->assertEquals([255, 0, 0], $color->getRGB());
        $this->assertEquals([0, 1, 0.5], $color->getHSL());
        $this->assertEquals('#ff0000', $color->getHex());

        $color->setRGB([0, 255, 0]);
        $this->assertEquals([0, 255, 0], $color->getRGB());
        $this->assertEquals([120, 1, 0.5], $color->getHSL());
        $this->assertEquals('#00ff00', $color->getHex());

        $color->setRGB([0, 0, 255]);
        $this->assertEquals([0, 0, 255], $color->getRGB());
        $this->assertEquals([240, 1, 0.5], $color->getHSL());
        $this->assertEquals('#0000ff', $color->getHex());
    }

}
