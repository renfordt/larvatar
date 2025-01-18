<?php

declare(strict_types=1);

namespace Renfordt\Larvatar;

use Exception;
use Renfordt\Larvatar\Enum\LarvatarTypes;

class Larvatar
{
    /**
     * @deprecated 2.0.2
     */
    public Avatar|Identicon|InitialsAvatar $avatar;
    public InitialsAvatar $initialsAvatar;
    public Identicon $identicon;
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
        $this->name = is_string($name) ? Name::make($name) : $name;

        $this->email = $email;
        $this->type = $type;

        if ($this->type === LarvatarTypes::InitialsAvatar) {
            $this->avatar = InitialsAvatar::make($this->name);
            $this->initialsAvatar = InitialsAvatar::make($this->name);
        } elseif ($this->type === LarvatarTypes::IdenticonLarvatar) {
            $this->avatar = Identicon::make($this->name);
            $this->identicon = Identicon::make($this->name);
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
     * @throws Exception
     */
    public function getImageHTML(bool $base64 = false): string
    {
        if ($this->type === LarvatarTypes::InitialsAvatar) {
            if (isset($this->font) && $this->font !== '' && $this->fontPath !== '') {
                $this->initialsAvatar->setFont($this->font, $this->fontPath);
            }
            $this->initialsAvatar->setSize($this->size);
            return $this->initialsAvatar->getHTML($base64);
        }

        if ($this->type === LarvatarTypes::IdenticonLarvatar) {
            $this->identicon->setSize($this->size);
            return $this->identicon->getHTML($base64);
        }

        $gravatar = new Gravatar($this->email);
        $gravatar->setType($this->type);
        $gravatar->setSize($this->size);

        return '<img src="' . $gravatar->generateGravatarLink() . '" />';
    }

    /**
     * Sets the size of the object.
     *
     * @param int $size The size of the object.
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
        if ($this->type === LarvatarTypes::InitialsAvatar) {
            return $this->initialsAvatar->getBase64();
        }

        if ($this->type === LarvatarTypes::IdenticonLarvatar) {
            return $this->identicon->getBase64();
        }

        return '';
    }

    /**
     * Set the font for Initial Avatar
     * @param string $fontFamily Font family of the used font, e.g. 'Roboto'
     * @param string $path Relative path to the true type font file, starting with a /, e.g. '/font/Roboto-Bold.ttf'
     */
    public function setFont(string $fontFamily, string $path): void
    {
        if ($this->type !== LarvatarTypes::InitialsAvatar) {
            return;
        }
        $this->font = $fontFamily;
        $this->fontPath = $path;
    }

    /**
     * Set the font weight for the initials' avatar.
     *
     * @param string $weight The font weight to be applied to the initials' avatar.
     */
    public function setWeight(string $weight): void
    {
        if ($this->type !== LarvatarTypes::InitialsAvatar) {
            return;
        }
        $this->initialsAvatar->setFontWeight($weight);
    }

    /**
     * Set the lightness level of the font used in the avatar.
     *
     * @param float $lightness The lightness value to be applied to the font.
     */
    public function setFontLightness(float $lightness): void
    {
        if ($this->type !== LarvatarTypes::InitialsAvatar) {
            return;
        }
        $this->initialsAvatar->setTextLightness($lightness);
    }

    /**
     * Set the lightness value for the foreground of the avatar.
     *
     * @param float $lightness The lightness value to be set for the foreground.
     */
    public function setForegroundLightness(float $lightness): void
    {
        if ($this->type === LarvatarTypes::InitialsAvatar) {
            $this->initialsAvatar->setForegroundLightness($lightness);
        }

        if ($this->type === LarvatarTypes::IdenticonLarvatar) {
            $this->identicon->setForegroundLightness($lightness);
        }
    }

    /**
     * Set the lightness level for the avatar's background.
     *
     * @param float $lightness The lightness value to set for the background.
     */
    public function setBackgroundLightness(float $lightness): void
    {
        if ($this->type === LarvatarTypes::InitialsAvatar) {
            $this->initialsAvatar->setBackgroundLightness($lightness);
        }

        if ($this->type === LarvatarTypes::IdenticonLarvatar) {
            $this->identicon->setBackgroundLightness($lightness);
        }
    }
}
