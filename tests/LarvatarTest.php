<?php

use PHPUnit\Framework\TestCase;
use Renfordt\Larvatar\Enum\LarvatarTypes;
use Renfordt\Larvatar\Larvatar;

class LarvatarTest extends TestCase
{
    public function testCreateLarvatar(): void
    {
        $larvatar = new Larvatar('Test Name', 'test@example.com', LarvatarTypes::InitialsAvatar);
        $this->assertEquals(
            '<?xml version="1.0" encoding="utf-8"?><svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="128" height="128"><circle cx="64" cy="64" r="64" style="fill: #9c3564" /><text x="50%" y="55%" style="fill: #ffffff; text-anchor: middle; dominant-baseline: middle; font-size: 64">TN</text></svg>',
            $larvatar->getImageHTML()
        );
    }

    public function testCreateGravatar(): void
    {
        $larvatar = new Larvatar('Test Name', 'test@example.com', LarvatarTypes::Gravatar);
        $this->assertEquals(
            '<img src="https://www.gravatar.com/avatar/b58996c504c5638798eb6b511e6f49af" />',
            $larvatar->getImageHTML()
        );
    }

    public function testCreateMp(): void
    {
        $larvatar = new Larvatar('Test Name', 'test@example.com', LarvatarTypes::mp);
        $this->assertEquals(
            '<img src="https://www.gravatar.com/avatar/b58996c504c5638798eb6b511e6f49af?d=mp&f=y" />',
            $larvatar->getImageHTML()
        );
    }

    public function testCreateIdenticon(): void
    {
        $larvatar = new Larvatar('Test Name', 'test@example.com', LarvatarTypes::identicon);
        $this->assertEquals(
            '<img src="https://www.gravatar.com/avatar/b58996c504c5638798eb6b511e6f49af?d=identicon&f=y" />',
            $larvatar->getImageHTML()
        );
    }

    public function testCreateMonsterid(): void
    {
        $larvatar = new Larvatar('Test Name', 'test@example.com', LarvatarTypes::monsterid);
        $this->assertEquals(
            '<img src="https://www.gravatar.com/avatar/b58996c504c5638798eb6b511e6f49af?d=monsterid&f=y" />',
            $larvatar->getImageHTML()
        );
    }

    public function testCreateWavatar(): void
    {
        $larvatar = new Larvatar('Test Name', 'test@example.com', LarvatarTypes::wavatar);
        $this->assertEquals(
            '<img src="https://www.gravatar.com/avatar/b58996c504c5638798eb6b511e6f49af?d=wavatar&f=y" />',
            $larvatar->getImageHTML()
        );
    }

    public function testCreateRetro(): void
    {
        $larvatar = new Larvatar('Test Name', 'test@example.com', LarvatarTypes::retro);
        $this->assertEquals(
            '<img src="https://www.gravatar.com/avatar/b58996c504c5638798eb6b511e6f49af?d=retro&f=y" />',
            $larvatar->getImageHTML()
        );
    }

    public function testCreateRobohash(): void
    {
        $larvatar = new Larvatar('Test Name', 'test@example.com', LarvatarTypes::robohash);
        $this->assertEquals(
            '<img src="https://www.gravatar.com/avatar/b58996c504c5638798eb6b511e6f49af?d=robohash&f=y" />',
            $larvatar->getImageHTML()
        );
    }

}