<?php

declare(strict_types=1);

namespace Renfordt\Larvatar;

use Exception;

abstract class Avatar
{
    protected Name $name;
    protected int $size = 100;
    protected float $backgroundLightness = 0.8;
    protected float $foregroundLightness = 0.35;

    /**
     * Retrieves the HTML representation of the data.
     *
     * @param bool $base64 Whether to return the HTML as base64 encoded string.
     * @return string The HTML representation of the data.
     * @throws Exception If the HTML generation fails.
     */
    abstract public function getHTML(bool $base64 = false): string;

    /**
     * Abstract function to get the base64 representation of a string
     *
     * @return string The base64 representation of the string
     */
    abstract public function getBase64(): string;

    /**
     * Get the name of the object
     *
     * @return Name The name of the object
     */
    public function getName(): Name
    {
        return $this->name;
    }

    /**
     * Set the Name object for the given instance
     *
     * @param Name|string $name The Name object or a string of the name
     */
    public function setName(Name|string $name): void
    {
        if (is_string($name)) {
            $name = Name::make($name);
        }
        $this->name = $name;
    }

    /**
     * Get the background lightness value
     *
     * @return float The background lightness value
     */
    public function getBackgroundLightness(): float
    {
        return $this->backgroundLightness;
    }

    /**
     * Set the background lightness
     *
     * @param float $backgroundLightness The background lightness value to set (between 0 and 1)
     */
    public function setBackgroundLightness(float $backgroundLightness): void
    {
        $this->backgroundLightness = (float)clamp($backgroundLightness, 0, 1);
    }

    /**
     * Retrieves the lightness level of the foreground.
     *
     * @return float The lightness value of the foreground
     */
    public function getForegroundLightness(): float
    {
        return $this->foregroundLightness;
    }

    /**
     * Sets the lightness value of the foreground within a specified range.
     *
     * @param float $foregroundLightness The desired lightness value, a float between 0 and 1.
     */
    public function setForegroundLightness(float $foregroundLightness): void
    {
        $this->foregroundLightness = (float)clamp($foregroundLightness, 0, 1);
    }

    /**
     * Get the size of the object
     *
     * @return int The size of the object
     */
    public function getSize(): int
    {
        return $this->size;
    }

    /**
     * Set the size of the object
     *
     * @param int $size The size to set for the object
     */
    public function setSize(int $size): void
    {
        $this->size = $size;
    }
}
