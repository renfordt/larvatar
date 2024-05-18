<?php

namespace Renfordt\Larvatar;

use Renfordt\Colors\HexColor;

class Name
{
    /**
     * @var string $name The name variable
     */
    private string $name = '';
    /**
     * @var array $splitNames An array to store split names
     */
    private array $splitNames;
    /**
     * @var string $hash The hashed name
     */
    private string $hash;

    public function __construct(string $name)
    {
        $this->name = $name;
        $this->splitNames = explode(' ', $name);
        $this->hash = $this->hash();
    }

    /**
     * Calculates the MD5 hash of the name.
     *
     * @return string
     */
    private function hash(): string
    {
        return md5($this->name);
    }

    /**
     * Create an instance of the Name class.
     *
     * @param  string  $name  The name to be used for creating the Name object.
     * @return Name The newly created Name object.
     */
    public static function make(string $name): Name
    {
        return new Name($name);
    }

    /**
     * Get the hexadecimal color value
     *
     * @param  int  $offset  The starting offset for the substring
     * @return HexColor The hexadecimal color string
     */
    public function getHexColor(int $offset = 0): HexColor
    {
        return HexColor::make('#'.substr($this->hash, $offset, 6));
    }

    /**
     * Get the name of the object.
     *
     * @return string The name of the object.
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * Retrieves the split names.
     *
     * @return array The split names.
     */
    public function getSplitNames(): array
    {
        return $this->splitNames;
    }

    /**
     * Get the hash value of the name
     *
     * @return string The hashed name.
     */
    public function getHash(): string
    {
        return $this->hash;
    }
}