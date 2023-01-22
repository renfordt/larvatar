<?php declare(strict_types=1);

use PHPUnit\Framework\TestCase;
use Renfordt\Larvatar\InitialsAvatar;

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
            '<?xml version="1.0" encoding="utf-8"?><svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="128" height="128"><circle cx="64" cy="64" r="64" style="fill: #9c3564" /><text x="50%" y="55%" style="fill: #ffffff; text-anchor: middle; dominant-baseline: middle; font-size: 64">TN</text></svg>',
            $initialsAvatar->generate()
        );
    }

    public function testCreateLarvatarByMethod(): void
    {
        $initialsAvatar = new InitialsAvatar();
        $initialsAvatar->setName('Test Name');
        $this->assertEquals(
            '<?xml version="1.0" encoding="utf-8"?><svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="128" height="128"><circle cx="64" cy="64" r="64" style="fill: #9c3564" /><text x="50%" y="55%" style="fill: #ffffff; text-anchor: middle; dominant-baseline: middle; font-size: 64">TN</text></svg>',
            $initialsAvatar->generate()
        );
    }

    public function testSetFont(): void
    {
        $initialsAvatar = new InitialsAvatar();
        $initialsAvatar->setName('Test Name');
        $initialsAvatar->setFont('Roboto', '/../src/font/Roboto-Bold.ttf');

        $this->assertEquals(
            '<?xml version="1.0" encoding="utf-8"?><svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="128" height="128"><circle cx="64" cy="64" r="64" style="fill: #9c3564" /><text x="50%" y="55%" style="fill: #ffffff; text-anchor: middle; dominant-baseline: middle; font-family: Roboto; font-size: 64">TN</text></svg>',
            $initialsAvatar->generate()
        );
    }

    public function testSetSize(): void
    {
        $initialsAvatar = new InitialsAvatar('Test Name');
        $initialsAvatar->setSize(500);
        $this->assertEquals(
            '<?xml version="1.0" encoding="utf-8"?><svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="500" height="500"><circle cx="250" cy="250" r="250" style="fill: #9c3564" /><text x="50%" y="55%" style="fill: #ffffff; text-anchor: middle; dominant-baseline: middle; font-size: 250">TN</text></svg>',
            $initialsAvatar->generate()
        );
    }
}