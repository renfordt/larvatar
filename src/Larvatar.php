<?php

namespace Renfordt\Larvatar;

use Renfordt\Larvatar\Enum\LarvatarTypes;

class Larvatar
{
    public Avatar $avatar;
    protected LarvatarTypes $type = LarvatarTypes::mp;
    protected Name $name;
    protected string $email;
    protected string $font;
    protected string $fontPath;
    protected int $size = 100;

    /**
     * Constructor for creating an instance of a Larvatar.
     *
     * @param LarvatarTypes $type The type of Larvatar to create.
     * @param string|Name $name Optional. The name to be used for generating the avatar. Defaults to an empty string.
     * @param string $email Optional. The email to be associated with the avatar. Defaults to an empty string.
     *
     * @return void
     */
    public function __construct(LarvatarTypes $type, string|Name $name = '', string $email = '')
    {
        if (is_string($name)) {
            $this->name = Name::make($name);
        } else {
            $this->name = $name;
        }

        $this->email = $email;
        $this->type = $type;

        if ($this->type == LarvatarTypes::InitialsAvatar) {
            $this->avatar = InitialsAvatar::make($this->name);
        } elseif ($this->type == LarvatarTypes::IdenticonLarvatar) {
            $this->avatar = Identicon::make($this->name);
        }
    }

    /**
     * Create a new Larvatar instance with the specified type, name, and email.
     *
     * @param LarvatarTypes $type The type of Larvatar to create.
     * @param string|Name $name The name or Name object to use for the Larvatar. Defaults to an empty string.
     * @param string $email The email associated with the Larvatar. Defaults to an empty string.
     * @return Larvatar A new instance of the Larvatar class.
     */
    public static function make(
        LarvatarTypes $type,
        string|Name $name = '',
        string $email = ''
    ): Larvatar {
        return new self($type, $name, $email);
    }

    /**
     * Create a new Larvatar instance based on the specified type, name, and email.
     *
     * @param LarvatarTypes $type The type of Larvatar to create.
     * @param string|Name $name The name associated with the Larvatar, defaults to an empty string.
     * @param string $email The email address associated with the Larvatar, defaults to an empty string.
     * @return Larvatar A newly created Larvatar instance.
     */
    public static function create(
        LarvatarTypes $type,
        string|Name $name = '',
        string $email = ''
    ): Larvatar {
        return self::make($type, $name, $email);
    }

    /**
     * Generates the HTML or SVG code directly for usage
     * @return string HTML or SVG code
     */
    public function getImageHTML(bool $base64 = false): string
    {
        if ($this->type == LarvatarTypes::InitialsAvatar || $this->type == LarvatarTypes::IdenticonLarvatar) {
            if (isset($this->font) && $this->font != '' && $this->fontPath != '') {
                $this->avatar->setFont($this->font, $this->fontPath);
            }
            $this->avatar->setSize($this->size);
            return $this->avatar->getHTML($base64);
        }

        $gravatar = new Gravatar($this->email);
        $gravatar->setType($this->type);
        $gravatar->setSize($this->size);

        return '<img src="' . $gravatar->generateGravatarLink() . '" />';
    }

    /**
     * Set the font for Initial Avatar
     * @param string $fontFamily Font family of the used font, e.g. 'Roboto'
     * @param string $path Relative path to the true type font file, starting with a /, e.g. '/font/Roboto-Bold.ttf'
     * @return void
     */
    public function setFont(string $fontFamily, string $path): void
    {
        $this->font = $fontFamily;
        $this->fontPath = $path;
    }

    /**
     * Sets the size of the object.
     *
     * @param int $size The size of the object.
     * @return void
     */
    public function setSize(int $size): void
    {
        $this->size = $size;
    }

    /**
     * Get the base64 string representation of the initials' avatar.
     *
     * @return string The base64 encoded string of the initials' avatar.
     */
    public function getBase64(): string
    {
        return $this->avatar->getBase64();
    }

    /**
     * Set the font weight for the initials' avatar.
     *
     * @param string $weight The font weight to be applied to the initials' avatar.
     * @return void
     */
    public function setWeight(string $weight): void
    {
        if (!isset($this->avatar)) {
            return;
        }
        $this->avatar->setFontWeight($weight);
    }

    /**
     * Set the lightness level of the font used in the avatar.
     *
     * @param float $lightness The lightness value to be applied to the font.
     * @return void
     */
    public function setFontLightness(float $lightness): void
    {
        $this->avatar->setTextLightness($lightness);
    }

    /**
     * Set the lightness level for the avatar's background.
     *
     * @param float $lightness The lightness value to set for the background.
     * @return void
     */
    public function setBackgroundLightness(float $lightness): void
    {
        $this->avatar->setBackgroundLightness($lightness);
    }
}
