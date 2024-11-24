<?php

use PHPUnit\Framework\TestCase;
use Renfordt\Larvatar\Name;

class NameTest extends TestCase
{
    public function hashProvider()
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

    public function splitNamesProvider()
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

    public function hexColorProvider()
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

    public function nameProvider()
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

    public function initialsProvider()
    {
        return [
            ["John", "J"],
            ["John Doe", "JD"],
            ["", ""],
            ["J@hn D*e!", "JD"],
            ["Jöhn Dœ", "JD"]
        ];
    }
    /**
     * Tests the getHash method with a single-word name.
     */
    /**
     * @dataProvider hashProvider
     */
    public function testGetHash($nameInput, $expectedHash)
    {
        $name = new Name($nameInput);
        $this->assertEquals($expectedHash, $name->getHash());
    }

    /**
     * @dataProvider splitNamesProvider
     */
    public function testGetSplitNames($nameInput, $expectedSplitNames)
    {
        $name = new Name($nameInput);
        $this->assertEquals($expectedSplitNames, $name->getSplitNames());
    }

    /**
     * Tests the getHexColor method with offset zero.
     */
    /**
     * @dataProvider hexColorProvider
     */
    public function testGetHexColor($nameInput, $offset, $expectedHexColor)
    {
        $name = new Name($nameInput);
        $this->assertEquals($expectedHexColor, $name->getHexColor($offset));
    }


    /**
     * @dataProvider nameProvider
     */
    public function testGetName($nameInput, $expectedName)
    {
        $name = new Name($nameInput);
        $this->assertEquals($expectedName, $name->getName());
    }

    /**
     * @dataProvider initialsProvider
     */
    public function testGetInitials($nameInput, $expectedInitials)
    {
        $name = new Name($nameInput);
        $this->assertEquals($expectedInitials, $name->getInitials());
    }
}
