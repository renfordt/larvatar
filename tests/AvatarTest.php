<?php

declare(strict_types=1);

namespace Renfordt\Larvatar\Tests;

use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\UsesClass;
use PHPUnit\Framework\TestCase;
use Renfordt\Larvatar\Avatar;
use Renfordt\Larvatar\InitialsAvatar;
use Renfordt\Larvatar\Name;

/**
 * Unit tests for the Avatar class.
 */
#[CoversClass(Avatar::class)]
#[UsesClass(InitialsAvatar::class)]
#[UsesClass(Name::class)]
class AvatarTest extends TestCase
{
    public static function fontDataProvider(): array
    {
        return [
            ['Arial', '/path/to/font.ttf'],
            ['', '/path/to/font.ttf'],
            ['Arial', ''],
            ['@#$%^&*()!', '/path/to/font.ttf'],
            ['Arial', '/path/to/f@nt!.ttf'],
        ];
    }

    public static function backgroundLightnessProvider(): array
    {
        return [
            [0.5, 0.5],
            [-0.5, 0],
            [1.5, 1],
            [0, 0],
            [1, 1],
        ];
    }

    public static function textLightnessProvider(): array
    {
        return [
            [0, 0],
            [1, 1],
            [0.5, 0.5],
            [-0.1, 0],
            [1.1, 1],
        ];
    }

    public static function nameProvider(): array
    {
        return [
            [new Name('Valid Object'), 'Valid Object'],
            ['Avatar Name', 'Avatar Name'],
            ['', ''],
            ['A!@#avatar%^&*()', 'A!@#avatar%^&*()'],
        ];
    }

    public static function fontSizeProvider(): array
    {
        return [
            [12],
            [-5],
            [0],
            [999999],
        ];
    }

    public static function fontWeightProvider(): array
    {
        return [
            ['normal'],
            ['bold'],
            ['100'],
            ['900'],
            [''],
            ['@#$%^&*()!'],
        ];
    }

    public static function sizeProvider(): array
    {
        return [
            [150],
            [0],
            [-50],
            [2000000],
        ];
    }

    /**
     * Test setting and getting font family and path.
     */
    #[DataProvider('fontDataProvider')]
    public function testFontMethods(string $font, string $path): void
    {
        $initialsAvatar = new InitialsAvatar(Name::create('John Doe'));
        $initialsAvatar->setFont($font, $path);
        $this->assertEquals($font, $initialsAvatar->getFontFamily());
        $this->assertEquals($path, $initialsAvatar->getFontPath());
    }

    /**
     * Test setting and getting background lightness.
     *
     */
    #[DataProvider('backgroundLightnessProvider')]
    public function testBackgroundLightnessMethods(float|int $input, float|int $expected): void
    {
        $initialsAvatar = new InitialsAvatar(Name::create('John Doe'));
        $initialsAvatar->setBackgroundLightness($input);
        $this->assertEquals($expected, $initialsAvatar->getBackgroundLightness());
    }

    /**
     * Test setting and getting text lightness.
     *
     */
    #[DataProvider('textLightnessProvider')]
    public function testTextLightnessMethods(int|float $input, int|float $expected): void
    {
        $initialsAvatar = new InitialsAvatar(Name::create('John Doe'));
        $initialsAvatar->setTextLightness($input);
        $this->assertEquals($expected, $initialsAvatar->getTextLightness());
    }

    #[DataProvider('textLightnessProvider')]
    public function testForegroundLightnessMethods(int|float $input, int|float $expected): void
    {
        $initialsAvatar = new InitialsAvatar(Name::create('John Doe'));
        $initialsAvatar->setForegroundLightness($input);
        $this->assertEquals($expected, $initialsAvatar->getForegroundLightness());
    }

    /**
     * Test setting and getting name.
     *
     */
    #[DataProvider('nameProvider')]
    public function testNameMethods(\Renfordt\Larvatar\Name|string $name, string $expected): void
    {
        $initialsAvatar = new InitialsAvatar(Name::create('John Doe'));
        $initialsAvatar->setName($name);
        $this->assertEquals($expected, $initialsAvatar->getName()->getName());
    }

    /**
     * Test setting and getting font size.
     *
     */
    #[DataProvider('fontSizeProvider')]
    public function testFontSizeMethods(int $input): void
    {
        $initialsAvatar = new InitialsAvatar(Name::create('John Doe'));
        $initialsAvatar->setFontSize($input);
        $this->assertEquals($input, $initialsAvatar->getFontSize());
    }

    /**
     * Test setting and getting font weight.
     *
     */
    #[DataProvider('fontWeightProvider')]
    public function testFontWeightMethods(string $input): void
    {
        $initialsAvatar = new InitialsAvatar(Name::create('John Doe'));
        $initialsAvatar->setFontWeight($input);
        $this->assertEquals($input, $initialsAvatar->getFontWeight());
    }

    /**
     * Test setting and getting size.
     *
     */
    #[DataProvider('sizeProvider')]
    public function testSizeMethods(int $input): void
    {
        $initialsAvatar = new InitialsAvatar(Name::create('John Doe'));
        $initialsAvatar->setSize($input);
        $this->assertEquals($input, $initialsAvatar->getSize());
    }


}
