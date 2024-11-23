<?php

declare(strict_types=1);

use PHPUnit\Framework\TestCase;
use Renfordt\Colors\HexColor;
use Renfordt\Larvatar\Enum\FormTypes;
use Renfordt\Larvatar\InitialsAvatar;
use Renfordt\Larvatar\Name;
use SVG\Nodes\Shapes\SVGPolygon;
use SVG\Nodes\Shapes\SVGRect;

final class InitialsAvatarTest extends TestCase
{
    /**
     * Tests the generate method with default configurations.
     */
    public function testGenerateDefault(): void
    {
        $name = Name::make('Test Name');
        $initialsAvatar = InitialsAvatar::make($name);

        $this->assertEquals(
            '<?xml version="1.0" encoding="utf-8"?><svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="100" height="100"><circle cx="50" cy="50" r="50" style="fill: #e5b3c9" /><text x="50%" y="55%" style="fill: #852d55; text-anchor: middle; dominant-baseline: middle; font-weight: normal; font-family: Segoe UI, Helvetica, sans-serif; font-size: 50px">TN</text></svg>',
            $initialsAvatar->generate()
        );
    }

    /**
     * Tests the generate method with square form.
     */
    public function testGenerateSquare(): void
    {
        $name = Name::make('Test Name');
        $initialsAvatar = InitialsAvatar::make($name);
        $initialsAvatar->setForm(FormTypes::Square);

        $this->assertEquals(
            '<?xml version="1.0" encoding="utf-8"?><svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="100" height="100"><rect x="0" y="0" width="100" height="100" style="fill: #e5b3c9" /><text x="50%" y="55%" style="fill: #852d55; text-anchor: middle; dominant-baseline: middle; font-weight: normal; font-family: Segoe UI, Helvetica, sans-serif; font-size: 50px">TN</text></svg>',
            $initialsAvatar->generate()
        );
    }

    /**
     * Tests the generate method with hexagon form and rotation.
     */
    public function testGenerateHexagonWithRotation(): void
    {
        $name = Name::make('Test Name');
        $initialsAvatar = InitialsAvatar::make($name);
        $initialsAvatar->setForm(FormTypes::Hexagon);
        $initialsAvatar->setRotation(30);

        $this->assertEquals(
            '<?xml version="1.0" encoding="utf-8"?><svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="100" height="100"><polygon points="93.301270189222,75 50,100 6.6987298107781,75 6.6987298107781,25 50,0 93.301270189222,25" style="fill: #e5b3c9" /><text x="50%" y="55%" style="fill: #852d55; text-anchor: middle; dominant-baseline: middle; font-weight: normal; font-family: Segoe UI, Helvetica, sans-serif; font-size: 50px">TN</text></svg>',
            $initialsAvatar->generate()
        );
    }

    public function testCreateLarvatarByConstructor(): void
    {
        $name = Name::make('Test Name');
        $initialsAvatar = new InitialsAvatar($name);
        $this->assertEquals(
            '<?xml version="1.0" encoding="utf-8"?><svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="100" height="100"><circle cx="50" cy="50" r="50" style="fill: #e5b3c9" /><text x="50%" y="55%" style="fill: #852d55; text-anchor: middle; dominant-baseline: middle; font-weight: normal; font-family: Segoe UI, Helvetica, sans-serif; font-size: 50px">TN</text></svg>',
            $initialsAvatar->generate()
        );
    }

    public function testCreateLarvatarByMethod(): void
    {
        $name = Name::make('Test Name');
        $initialsAvatar = InitialsAvatar::make($name);
        $this->assertEquals(
            '<?xml version="1.0" encoding="utf-8"?><svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="100" height="100"><circle cx="50" cy="50" r="50" style="fill: #e5b3c9" /><text x="50%" y="55%" style="fill: #852d55; text-anchor: middle; dominant-baseline: middle; font-weight: normal; font-family: Segoe UI, Helvetica, sans-serif; font-size: 50px">TN</text></svg>',
            $initialsAvatar->generate()
        );
    }

    public function testCreateLarvatarByMethodWithString(): void
    {
        $initialsAvatar = InitialsAvatar::make('Test Name');
        $this->assertEquals(
            '<?xml version="1.0" encoding="utf-8"?><svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="100" height="100"><circle cx="50" cy="50" r="50" style="fill: #e5b3c9" /><text x="50%" y="55%" style="fill: #852d55; text-anchor: middle; dominant-baseline: middle; font-weight: normal; font-family: Segoe UI, Helvetica, sans-serif; font-size: 50px">TN</text></svg>',
            $initialsAvatar->generate()
        );
    }

    public function testCreateLarvatarBySetNameMethod(): void
    {
        $name1 = Name::make('Different Name');
        $initialsAvatar = InitialsAvatar::make($name1);
        $name2 = Name::make('Test Name');
        $initialsAvatar->setName($name2);
        $this->assertEquals(
            '<?xml version="1.0" encoding="utf-8"?><svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="100" height="100"><circle cx="50" cy="50" r="50" style="fill: #e5b3c9" /><text x="50%" y="55%" style="fill: #852d55; text-anchor: middle; dominant-baseline: middle; font-weight: normal; font-family: Segoe UI, Helvetica, sans-serif; font-size: 50px">TN</text></svg>',
            $initialsAvatar->generate()
        );
    }

    public function testSetFont(): void
    {
        $name = Name::make('Test Name');
        $initialsAvatar = InitialsAvatar::make($name);
        $initialsAvatar->setFont('Roboto', '/../src/font/Roboto-Bold.ttf');

        $this->assertEquals(
            '<?xml version="1.0" encoding="utf-8"?><svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="100" height="100"><circle cx="50" cy="50" r="50" style="fill: #e5b3c9" /><text x="50%" y="55%" style="fill: #852d55; text-anchor: middle; dominant-baseline: middle; font-weight: normal; font-family: Roboto; font-size: 50px">TN</text></svg>',
            $initialsAvatar->generate()
        );
    }

    public function testSetSize(): void
    {
        $name = Name::make('Test Name');
        $initialsAvatar = InitialsAvatar::make($name);
        $initialsAvatar->setSize(500);
        $this->assertEquals(
            '<?xml version="1.0" encoding="utf-8"?><svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="500" height="500"><circle cx="250" cy="250" r="250" style="fill: #e5b3c9" /><text x="50%" y="55%" style="fill: #852d55; text-anchor: middle; dominant-baseline: middle; font-weight: normal; font-family: Segoe UI, Helvetica, sans-serif; font-size: 250px">TN</text></svg>',
            $initialsAvatar->generate()
        );
    }

    public function testGenerateWithBase64(): void
    {
        $name = Name::make('Test Name');
        $initialsAvatar = InitialsAvatar::make($name);
        $svg = $initialsAvatar->generate();
        $base64 = $initialsAvatar->getBase64();

        $this->assertEquals(
            'data:image/svg+xml;base64,' . base64_encode($svg),
            $base64
        );
    }

    public function testGetSquare(): void
    {
        $name = Name::make('Test Name');
        $initialsAvatar = InitialsAvatar::make($name);
        $reflect = new ReflectionClass($initialsAvatar);
        $method = $reflect->getMethod('getSquare');

        $color = HexColor::create('#000000')->toHSL();

        $result = $method->invoke($initialsAvatar, 128, $color);

        $this->assertInstanceOf(SVGRect::class, $result);
        $this->assertEquals(0, $result->getX());
        $this->assertEquals(0, $result->getY());
        $this->assertEquals(128, $result->getWidth());
        $this->assertEquals(128, $result->getHeight());
        $this->assertEquals('#000000', $result->getStyle('fill'));
    }

    public function testGetHexagon(): void
    {
        $name = Name::make('Test Name');
        $initialsAvatar = InitialsAvatar::make($name);
        $reflect = new ReflectionClass($initialsAvatar);
        $method = $reflect->getMethod('getHexagon');
        $method->setAccessible(true);

        $color = HexColor::create('#000000')->toHSL();

        $expectedPoints = [
            [119.4256258422, 96],
            [64, 128],
            [8.5743741577959, 96],
            [8.5743741577959, 32],
            [64, 0],
            [119.4256258422, 32]
        ];

        $result = $method->invoke($initialsAvatar, 128, $color, 30);

        $this->assertInstanceOf(SVGPolygon::class, $result);
        $this->assertEquals('#000000', $result->getStyle('fill'));
        $this->assertEquals($expectedPoints, $result->getPoints());
    }

    public function testSetRotation(): void
    {
        $name = Name::make('Test Name');
        $initialsAvatar = InitialsAvatar::make($name);
        $initialsAvatar->setRotation(45);
        $reflector = new ReflectionObject($initialsAvatar);
        $property = $reflector->getProperty('rotation');
        $property->setAccessible(true);
        $this->assertEquals(45, $property->getValue($initialsAvatar));
    }

    public function testSetForm(): void
    {
        $name = Name::make('Test Name');
        $initialsAvatar = InitialsAvatar::make($name);

        $initialsAvatar->setForm('circle');
        $reflector = new ReflectionObject($initialsAvatar);
        $property = $reflector->getProperty('form');
        $property->setAccessible(true);
        $this->assertEquals(FormTypes::Circle, $property->getValue($initialsAvatar));

        $initialsAvatar->setForm('square');
        $this->assertEquals(FormTypes::Square, $property->getValue($initialsAvatar));

        $initialsAvatar->setForm('hexagon');
        $this->assertEquals(FormTypes::Hexagon, $property->getValue($initialsAvatar));

        $initialsAvatar->setForm(FormTypes::Circle);
        $this->assertEquals(FormTypes::Circle, $property->getValue($initialsAvatar));

        $initialsAvatar->setForm(FormTypes::Square);
        $this->assertEquals(FormTypes::Square, $property->getValue($initialsAvatar));

        $initialsAvatar->setForm(FormTypes::Hexagon);
        $this->assertEquals(FormTypes::Hexagon, $property->getValue($initialsAvatar));
    }

    public function testSetFormWithInvalidValue(): void
    {
        $this->expectException(ValueError::class);

        $name = Name::make('Test Name');
        $initialsAvatar = InitialsAvatar::make($name);
        $initialsAvatar->setForm('invalid_form');
    }

    public function testSetFontWeight(): void
    {
        $name = Name::make('Test Name');
        $initialsAvatar = InitialsAvatar::make($name);
        $initialsAvatar->setFontWeight('bold');
        $reflector = new ReflectionObject($initialsAvatar);
        $property = $reflector->getProperty('fontWeight');
        $property->setAccessible(true);
        $this->assertEquals('bold', $property->getValue($initialsAvatar));
    }

    public function testGetBackgroundLightnessDefaultValue(): void
    {
        $name = Name::make('Test Name');
        $initialsAvatar = InitialsAvatar::make($name);
        $this->assertEquals(
            0.8,
            $initialsAvatar->getBackgroundLightness()
        );
    }

    public function testGetBackgroundLightnessAfterSettingValue(): void
    {
        $name = Name::make('Test Name');
        $initialsAvatar = InitialsAvatar::make($name);
        $initialsAvatar->setBackgroundLightness(0.7);
        $this->assertEquals(
            0.7,
            $initialsAvatar->getBackgroundLightness()
        );
    }

    public function testGetBackgroundLightnessAfterSettingExceedingValue(): void
    {
        $name = Name::make('Test Name');
        $initialsAvatar = InitialsAvatar::make($name);
        $initialsAvatar->setBackgroundLightness(1.1);
        $this->assertEquals(
            1.0,
            $initialsAvatar->getBackgroundLightness()
        );
    }

    public function testGetBackgroundLightnessAfterSettingTooLowValue(): void
    {
        $name = Name::make('Test Name');
        $initialsAvatar = InitialsAvatar::make($name);
        $initialsAvatar->setBackgroundLightness(-1.3);
        $this->assertEquals(
            0.0,
            $initialsAvatar->getBackgroundLightness()
        );
    }

    public function testGetTextLightnessDefaultValue(): void
    {
        $name = Name::make('Test Name');
        $initialsAvatar = InitialsAvatar::make($name);
        $this->assertEquals(
            0.35,
            $initialsAvatar->getTextLightness()
        );
    }

    public function testGetTextLightnessAfterSettingValue(): void
    {
        $name = Name::make('Test Name');
        $initialsAvatar = InitialsAvatar::make($name);
        $initialsAvatar->setTextLightness(0.5);
        $this->assertEquals(
            0.5,
            $initialsAvatar->getTextLightness()
        );
    }

    public function testGetTextLightnessAfterSettingExceedingValue(): void
    {
        $name = Name::make('Test Name');
        $initialsAvatar = InitialsAvatar::make($name);
        $initialsAvatar->setTextLightness(1.1);
        $this->assertEquals(
            1.0,
            $initialsAvatar->getTextLightness()
        );
    }

    public function testGetTextLightnessAfterSettingTooLowValue(): void
    {
        $name = Name::make('Test Name');
        $initialsAvatar = InitialsAvatar::make($name);
        $initialsAvatar->setTextLightness(-1.3);
        $this->assertEquals(
            0.0,
            $initialsAvatar->getTextLightness()
        );
    }

    /**
     * Tests if the set offset returns correct value
     * @return void
     */
    public function testGetOffsetIsSetCorrectly(): void
    {
        $name = Name::make('Test Name');
        $initialsAvatar = InitialsAvatar::make($name);
        $initialsAvatar->setOffset(10);
        $this->assertSame(10, $initialsAvatar->getOffset());
    }

    /**
     * Tests if the default value should be zero
     * @return void
     */
    public function testGetOffsetReturnsDefaultValue(): void
    {
        $name = Name::make('Test Name');
        $initialsAvatar = InitialsAvatar::make($name);
        $this->assertSame(0, $initialsAvatar->getOffset());
    }
}
