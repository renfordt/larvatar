<?php

namespace Renfordt\Larvatar;

abstract class Avatar
{
    protected int $fontSize = 0;

    protected string $fontFamily = 'sans serif';
    protected string $fontPath = '';
    protected string $fontWeight = 'normal';
    protected Name $name;
    protected int $size = 100;
    protected float $backgroundLightness = 0.8;
    protected float $textLightness = 0.35;

    /**
     * Retrieves the HTML representation of the data.
     *
     * @param bool $base64 Whether to return the HTML as base64 encoded string.
     * @return string The HTML representation of the data.
     * @throws \Exception If the HTML generation fails.
     */
    abstract public function getHTML(bool $base64 = false): string;

    /**
     * Abstract function to get the base64 representation of a string
     *
     * @return string The base64 representation of the string
     */
    abstract public function getBase64(): string;

    /**
     * Get the font size
     *
     * @return int The font size value
     */
    public function getFontSize(): int
    {
        return $this->fontSize;
    }

    /**
     * Set the font size.
     *
     * @param int $fontSize The font size.
     * @return void
     */
    public function setFontSize(int $fontSize): void
    {
        $this->fontSize = $fontSize;
    }

    /**
     * Get the font family
     *
     * @return string The font family
     */
    public function getFontFamily(): string
    {
        return $this->fontFamily;
    }

    /**
     * Set the font family for the application
     *
     * @param string $fontFamily The font family to set
     * @return void
     */
    public function setFontFamily(string $fontFamily): void
    {
        $this->fontFamily = $fontFamily;
    }

    /**
     * Get the font path
     *
     * @return string The font path
     */
    public function getFontPath(): string
    {
        return $this->fontPath;
    }

    /**
     * Set the font path
     *
     * @param string $fontPath The path to the font
     * @return void
     */
    public function setFontPath(string $fontPath): void
    {
        $this->fontPath = $fontPath;
    }

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
     * @param Name $name The Name object
     *
     * @return void
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
     * @return void
     */
    public function setBackgroundLightness(float $backgroundLightness): void
    {
        $this->backgroundLightness = clamp($backgroundLightness, 0, 1);
    }

    /**
     * Get the lightness value of the text
     *
     * @return float The lightness value of the text
     */
    public function getTextLightness(): float
    {
        return $this->textLightness;
    }

    /**
     * Set the text lightness value
     *
     * @param float $textLightness The text lightness value to be set
     * @return void
     */
    public function setTextLightness(float $textLightness): void
    {
        $this->textLightness = clamp($textLightness, 0, 1);
    }

    /**
     * Get the font weight
     *
     * @return string The font weight
     */
    public function getFontWeight(): string
    {
        return $this->fontWeight;
    }

    /**
     * Set the font weight for the application
     *
     * @param string $fontWeight The font weight to set
     * @return void
     */
    public function setFontWeight(string $fontWeight): void
    {
        $this->fontWeight = $fontWeight;
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
     * @return void
     */
    public function setSize(int $size): void
    {
        $this->size = $size;
    }

    /**
     * Sets the font family and path
     *
     * @param string $font The font family
     * @param string $path The font path
     *
     * @return void
     */
    public function setFont(string $font, string $path)
    {
        $this->setFontFamily($font);
        $this->setFontPath($path);
    }


}
