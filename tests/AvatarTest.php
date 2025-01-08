<?php

declare(strict_types=1);

use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;
use Renfordt\Larvatar\Avatar;
use Renfordt\Larvatar\Name;

/**
 * Unit tests for the Avatar class.
 */
#[CoversClass(Avatar::class)]
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
        $mock = $this->getMockForAbstractClass(Avatar::class);
        $mock->setFont($font, $path);
        $this->assertEquals($font, $mock->getFontFamily());
        $this->assertEquals($path, $mock->getFontPath());
    }

    /**
     * Test setting and getting background lightness.
     *
     */
    #[DataProvider('backgroundLightnessProvider')]
    public function testBackgroundLightnessMethods(float|int $input, float|int $expected): void
    {
        $mock = $this->getMockForAbstractClass(Avatar::class);
        $mock->setBackgroundLightness($input);
        $this->assertEquals($expected, $mock->getBackgroundLightness());
    }

    /**
     * Test setting and getting text lightness.
     *
     */
    #[DataProvider('textLightnessProvider')]
    public function testTextLightnessMethods(int|float $input, int|float $expected): void
    {
        $mock = $this->getMockForAbstractClass(Avatar::class);
        $mock->setTextLightness($input);
        $this->assertEquals($expected, $mock->getTextLightness());
    }

    /**
     * Test setting and getting name.
     *
     */
    #[DataProvider('nameProvider')]
    public function testNameMethods(\Renfordt\Larvatar\Name|string $name, string $expected): void
    {
        $mock = $this->getMockForAbstractClass(Avatar::class);
        $mock->setName($name);
        $this->assertEquals($expected, $mock->getName()->getName());
    }

    /**
     * Test setting and getting font size.
     *
     */
    #[DataProvider('fontSizeProvider')]
    public function testFontSizeMethods(int $input): void
    {
        $mock = $this->getMockForAbstractClass(Avatar::class);
        $mock->setFontSize($input);
        $this->assertEquals($input, $mock->getFontSize());
    }

    /**
     * Test setting and getting font weight.
     *
     */
    #[DataProvider('fontWeightProvider')]
    public function testFontWeightMethods(string $input): void
    {
        $mock = $this->getMockForAbstractClass(Avatar::class);
        $mock->setFontWeight($input);
        $this->assertEquals($input, $mock->getFontWeight());
    }

    /**
     * Test setting and getting size.
     *
     */
    #[DataProvider('sizeProvider')]
    public function testSizeMethods(int $input): void
    {
        $mock = $this->getMockForAbstractClass(Avatar::class);
        $mock->setSize($input);
        $this->assertEquals($input, $mock->getSize());
    }
}
