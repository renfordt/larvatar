<?php

namespace Renfordt\Larvatar;

use Renfordt\Larvatar\Enum\LarvatarTypes;

class Larvatar
{
    public InitialsAvatar $initialsAvatar;
    protected LarvatarTypes $type = LarvatarTypes::mp;
    protected Name $name;
    protected string $email;
    protected string $font;
    protected string $fontPath;
    protected int $size = 100;

    /**
     * Constructs a new instance of the class.
     *
     * @param  string  $name  The name. Default is an empty string.
     * @param  string  $email  The email. Default is an empty string.
     * @param  int|LarvatarTypes  $type  The type. Default is LarvatarTypes::mp.
     */
    public function __construct(LarvatarTypes $type, string $name = '', string $email = '')
    {
        $this->name = Name::make($name);
        $this->email = $email;
        $this->type = $type;

        if ($this->type == LarvatarTypes::InitialsAvatar) {
            $this->initialsAvatar = new InitialsAvatar($this->name);
        }
    }

    public static function make(
        LarvatarTypes $type,
        string $name = '',
        string $email = ''
    ): Larvatar {
        return new self($type, $name, $email);
    }

    /**
     * Generates the HTML or SVG code directly for usage
     * @return string HTML or SVG code
     */
    public function getImageHTML(string $encoding = ''): string
    {
        if ($this->type == LarvatarTypes::InitialsAvatar ) {
            if (isset($this->font) && $this->font != '' && $this->fontPath != '') {
                $this->initialsAvatar->setFont($this->font, $this->fontPath);
            }
            $this->initialsAvatar->setSize($this->size);
            if ($encoding == 'base64') {
                return '<img src="'.$this->initialsAvatar->generate().'" />';
            } else {
                return $this->initialsAvatar->generate();
            }
        }

        $gravatar = new Gravatar($this->email);
        $gravatar->setType($this->type);
        $gravatar->setSize($this->size);

        return '<img src="'.$gravatar->generateGravatarLink().'" />';
    }

    /**
     * Set the font for Initial Avatar
     * @param  string  $fontFamily  Font family of the used font, e.g. 'Roboto'
     * @param  string  $path  Relative path to the true type font file, starting with a /, e.g. '/font/Roboto-Bold.ttf'
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
     * @param  int  $size  The size of the object.
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
        return $this->initialsAvatar->generate();
    }
}