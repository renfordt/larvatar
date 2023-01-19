<?php declare(strict_types=1);

use PHPUnit\Framework\TestCase;
use Renfordt\Larvatar\Larvatar;

final class LarvatarTest extends TestCase
{
    public function testHexGeneration(): void
    {
        $larvatar = new Larvatar();
        $larvatar->setName('Test Name');

        $this->assertEquals(
            '#9c3564',
            $larvatar->generateHexColor()
        );
    }

    public function testCreateLarvatarByConstructor(): void
    {
        $larvatar = new Larvatar('Test Name');
        $this->assertEquals(
            '<?xml version="1.0" encoding="utf-8"?><svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="128" height="128"><circle cx="64" cy="64" r="64" style="fill: #9c3564" /><text x="50%" y="55%" style="fill: #ffffff; text-anchor: middle; dominant-baseline: middle; font-size: 64">TN</text></svg>',
            $larvatar->generate()
        );
    }

    public function testCreateLarvatarByMethod(): void
    {
        $larvatar = new Larvatar();
        $larvatar->setName('Test Name');
        $this->assertEquals(
            '<?xml version="1.0" encoding="utf-8"?><svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="128" height="128"><circle cx="64" cy="64" r="64" style="fill: #9c3564" /><text x="50%" y="55%" style="fill: #ffffff; text-anchor: middle; dominant-baseline: middle; font-size: 64">TN</text></svg>',
            $larvatar->generate()
        );
    }
}