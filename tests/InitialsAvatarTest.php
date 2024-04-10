<?php declare(strict_types=1);

use PHPUnit\Framework\TestCase;
use Renfordt\Larvatar\Color;
use Renfordt\Larvatar\Enum\ColorType;
use Renfordt\Larvatar\InitialsAvatar;
use SVG\Nodes\Shapes\SVGPolygon;
use SVG\Nodes\Shapes\SVGRect;

final class InitialsAvatarTest extends TestCase
{
    public function testHexGeneration(): void
    {
        $initialsAvatar = new InitialsAvatar();
        $initialsAvatar->setName('Test Name');

        $this->assertEquals(
            '#9c3564',
            $initialsAvatar->generateHexColor()
        );
    }

    public function testCreateLarvatarByConstructor(): void
    {
        $initialsAvatar = new InitialsAvatar('Test Name');
        $this->assertEquals(
            '<?xml version="1.0" encoding="utf-8"?><svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="128" height="128"><circle cx="64" cy="64" r="64" style="fill: #e5b3ca" /><text x="50%" y="55%" style="fill: #852e55; text-anchor: middle; dominant-baseline: middle; font-size: 64px">TN</text></svg>',
            $initialsAvatar->generate()
        );
    }

    public function testCreateLarvatarByMethod(): void
    {
        $initialsAvatar = new InitialsAvatar();
        $initialsAvatar->setName('Test Name');
        $this->assertEquals(
            '<?xml version="1.0" encoding="utf-8"?><svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="128" height="128"><circle cx="64" cy="64" r="64" style="fill: #e5b3ca" /><text x="50%" y="55%" style="fill: #852e55; text-anchor: middle; dominant-baseline: middle; font-size: 64px">TN</text></svg>',
            $initialsAvatar->generate()
        );
    }

    public function testSetFont(): void
    {
        $initialsAvatar = new InitialsAvatar();
        $initialsAvatar->setName('Test Name');
        $initialsAvatar->setFont('Roboto', '/../src/font/Roboto-Bold.ttf');

        $this->assertEquals(
            '<?xml version="1.0" encoding="utf-8"?><svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="128" height="128"><circle cx="64" cy="64" r="64" style="fill: #e5b3ca" /><text x="50%" y="55%" style="fill: #852e55; text-anchor: middle; dominant-baseline: middle; font-family: Roboto; font-size: 64px">TN</text></svg>',
            $initialsAvatar->generate()
        );
    }

    public function testSetSize(): void
    {
        $initialsAvatar = new InitialsAvatar('Test Name');
        $initialsAvatar->setSize(500);
        $this->assertEquals(
            '<?xml version="1.0" encoding="utf-8"?><svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="500" height="500"><circle cx="250" cy="250" r="250" style="fill: #e5b3ca" /><text x="50%" y="55%" style="fill: #852e55; text-anchor: middle; dominant-baseline: middle; font-size: 250px">TN</text></svg>',
            $initialsAvatar->generate()
        );
    }

    public function testGenerateWithBase64(): void
    {
        $initialsAvatar = new InitialsAvatar('Test Name');
        $svg = $initialsAvatar->generate();
        $base64 = $initialsAvatar->generate([], 'base64');

        $this->assertEquals(
            'data:image/svg+xml;base64,'.base64_encode($svg),
            $base64
        );
    }

    public function testGetSquare(): void
    {
        $initialsAvatar = new InitialsAvatar('Test Name');
        $reflect = new \ReflectionClass($initialsAvatar);
        $method = $reflect->getMethod('getSquare');

        $color = new Color(ColorType::Hex, '#000000');

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
        $initialsAvatar = new InitialsAvatar('Test Name');
        $reflect = new \ReflectionClass($initialsAvatar);
        $method = $reflect->getMethod('getHexagon');
        $method->setAccessible(true);

        $color = new Color(ColorType::Hex, '#000000');

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
        $initialsAvatar = new InitialsAvatar('Test Name');
        $initialsAvatar->setRotation(45);
        $reflector = new \ReflectionObject($initialsAvatar);
        $property = $reflector->getProperty('rotation');
        $property->setAccessible(true);
        $this->assertEquals(45, $property->getValue($initialsAvatar));
    }
}
    public function testSetForm(): void
    {
        $initialsAvatar = new InitialsAvatar('Test Name');

        $initialsAvatar->setForm('circle');
        $reflector = new \ReflectionObject($initialsAvatar);
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
}
