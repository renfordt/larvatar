<?php

use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;
use Renfordt\Larvatar\Name;

class NameTest extends TestCase
{
    public static function hashProvider(): array
    {
        return [
            ["John", md5("John")],
            ["John Doe", md5("John Doe")],
            ["", md5("")],
            ["J@hn D*e!", md5("J@hn D*e!")],
            ["Jöhn Dœ", md5("Jöhn Dœ")],
            ["鸡藕和讷 兜鹅", md5("鸡藕和讷 兜鹅")],
        ];
    }

    public static function splitNamesProvider(): array
    {
        return [
            ["John", ["John"]],
            ["John Doe", ["John", "Doe"]],
            ["", [""]],
            ["J@hn D*e!", ["J@hn", "D*e!"]],
            ["Jöhn Dœ", ["Jöhn", "Dœ"]],
            ["鸡藕和讷 兜鹅", ["鸡藕和讷", "兜鹅"]],
        ];
    }

    public static function hexColorProvider(): array
    {
        return [
            ["John", 0, '#' . substr(md5("John"), 0, 6)],
            ["John", 3, '#' . substr(md5("John"), 3, 6)],
            ["John", 6, '#' . substr(md5("John"), 6, 6)],
            ["", 0, '#' . substr(md5(""), 0, 6)],
            ["J@hn", 0, '#' . substr(md5("J@hn"), 0, 6)],
            ["Jöhn", 0, '#' . substr(md5("Jöhn"), 0, 6)],
            ["鸡藕和讷", 0, '#' . substr(md5("鸡藕和讷"), 0, 6)],
        ];
    }

    public static function nameProvider(): array
    {
        return [
            ["John", "John"],
            ["John Doe", "John Doe"],
            ["", ""],
            ["J@hn D*e!", "J@hn D*e!"],
            ["Jöhn Dœ", "Jöhn Dœ"],
            ["鸡藕和讷 兜鹅", "鸡藕和讷 兜鹅"],
        ];
    }

    public static function initialsProvider(): array
    {
        return [
            ["John", "J"],
            ["John Doe", "JD"],
            ["", ""],
            ["J@hn D*e!", "JD"],
            ["Jöhn Dœ", "JD"]
        ];
    }

    #[DataProvider('hashProvider')]
    public function testGetHash($nameInput, $expectedHash)
    {
        $name = new Name($nameInput);
        $this->assertEquals($expectedHash, $name->getHash());
    }

    #[DataProvider('splitNamesProvider')]
    public function testGetSplitNames($nameInput, $expectedSplitNames)
    {
        $name = new Name($nameInput);
        $this->assertEquals($expectedSplitNames, $name->getSplitNames());
    }

    #[DataProvider('hexColorProvider')]
    public function testGetHexColor($nameInput, $offset, $expectedHexColor)
    {
        $name = new Name($nameInput);
        $this->assertEquals($expectedHexColor, $name->getHexColor($offset));
    }

    #[DataProvider('nameProvider')]
    public function testGetName($nameInput, $expectedName)
    {
        $name = new Name($nameInput);
        $this->assertEquals($expectedName, $name->getName());
    }

    #[DataProvider('initialsProvider')]
    public function testGetInitials($nameInput, $expectedInitials)
    {
        $name = new Name($nameInput);
        $this->assertEquals($expectedInitials, $name->getInitials());
    }

    #[DataProvider('initialsProvider')]
    public function testMakeMethodInitials($nameInput, $expectedInitials)
    {
        $name = Name::make($nameInput);
        $this->assertEquals($expectedInitials, $name->getInitials());
    }

    #[DataProvider('initialsProvider')]
    public function testCreateMethodInitials($nameInput, $expectedInitials)
    {
        $name = Name::create($nameInput);
        $this->assertEquals($expectedInitials, $name->getInitials());
    }


}