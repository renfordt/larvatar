<?php

use PHPUnit\Framework\TestCase;
use Renfordt\Larvatar\Avatar;
use Renfordt\Larvatar\Name;
/**
 * Unit tests for the Avatar class.
 */
class AvatarTest extends TestCase
{
    /**
     * Test setting and getting font family and path.
     *
     * @dataProvider fontDataProvider
     */
    public function testFontMethods($font, $path)
    {
        $mock = $this->getMockForAbstractClass(Avatar::class);
        $mock->setFont($font, $path);
        $this->assertEquals($font, $mock->getFontFamily());
        $this->assertEquals($path, $mock->getFontPath());
    }

    public function fontDataProvider()
    {
        return [
            ['Arial', '/path/to/font.ttf'],
            ['', '/path/to/font.ttf'],
            ['Arial', ''],
            ['@#$%^&*()!', '/path/to/font.ttf'],
            ['Arial', '/path/to/f@nt!.ttf'],
        ];
    }

    /**
     * Test setting and getting background lightness.
     *
     * @dataProvider backgroundLightnessProvider
     */
    public function testBackgroundLightnessMethods($input, $expected)
    {
        $mock = $this->getMockForAbstractClass(Avatar::class);
        $mock->setBackgroundLightness($input);
        $this->assertEquals($expected, $mock->getBackgroundLightness());
    }

    public function backgroundLightnessProvider()
    {
        return [
            [0.5, 0.5],
            [-0.5, 0],
            [1.5, 1],
            [0, 0],
            [1, 1],
        ];
    }

    /**
     * Test setting and getting text lightness.
     *
     * @dataProvider textLightnessProvider
     */
    public function testTextLightnessMethods($input, $expected)
    {
        $mock = $this->getMockForAbstractClass(Avatar::class);
        $mock->setTextLightness($input);
        $this->assertEquals($expected, $mock->getTextLightness());
    }

    public function textLightnessProvider()
    {
        return [
            [0, 0],
            [1, 1],
            [0.5, 0.5],
            [-0.1, 0],
            [1.1, 1],
        ];
    }

    /**
     * Test setting and getting name.
     *
     * @dataProvider nameProvider
     */
    public function testNameMethods($name, $expected)
    {
        $mock = $this->getMockForAbstractClass(Avatar::class);
        $mock->setName($name);
        $this->assertEquals($expected, $mock->getName()->getName());
    }

    public function nameProvider()
    {
        return [
            [new Name('Valid Object'), 'Valid Object'],
            ['Avatar Name', 'Avatar Name'],
            ['', ''],
            ['A!@#avatar%^&*()', 'A!@#avatar%^&*()'],
        ];
    }

    /**
     * Test setting and getting font size.
     *
     * @dataProvider fontSizeProvider
     */
    public function testFontSizeMethods($input)
    {
        $mock = $this->getMockForAbstractClass(Avatar::class);
        $mock->setFontSize($input);
        $this->assertEquals($input, $mock->getFontSize());
    }

    public function fontSizeProvider()
    {
        return [
            [12],
            [-5],
            [0],
            [999999],
        ];
    }

    /**
     * Test setting and getting font weight.
     *
     * @dataProvider fontWeightProvider
     */
    public function testFontWeightMethods($input)
    {
        $mock = $this->getMockForAbstractClass(Avatar::class);
        $mock->setFontWeight($input);
        $this->assertEquals($input, $mock->getFontWeight());
    }

    public function fontWeightProvider()
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

    /**
     * Test setting and getting size.
     *
     * @dataProvider sizeProvider
     */
    public function testSizeMethods($input)
    {
        $mock = $this->getMockForAbstractClass(Avatar::class);
        $mock->setSize($input);
        $this->assertEquals($input, $mock->getSize());
    }

    public function sizeProvider()
    {
        return [
            [150],
            [0],
            [-50],
            [2000000],
        ];
    }
}