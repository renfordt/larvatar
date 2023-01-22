<?php

namespace Renfordt\Larvatar;

use Renfordt\Larvatar\Enum\LarvatarTypes;

class Larvatar
{
    protected LarvatarTypes $type = LarvatarTypes::mp;
    protected string $name;
    protected string $email;
    protected string $font;
    protected string $fontPath;
    protected int $size = 100;

    /**
     * @param  string  $name  The first and second name or the username, separated by a space
     * @param  string  $email  The email of the user, used to create a hash for Gravatar
     * @param  int|LarvatarTypes  $type  Type of Larvatar, currently from 0 to 7 or better use LarvatarType enum
     */
    public function __construct(string $name = '', string $email = '', int|LarvatarTypes $type = LarvatarTypes::mp)
    {
        $this->name = $name;
        $this->email = $email;
        if (is_int($type)) {
            $this->type = LarvatarTypes::from($type);
        } elseif ($type instanceof LarvatarTypes) {
            $this->type = $type;
        }
    }

    /**
     * Generates the HTML or SVG code directly for usage
     * @return string HTML or SVG code
     */
    public function getImageHTML(): string
    {
        if ($this->type == LarvatarTypes::InitialsAvatar) {
            $initial_avatar = new InitialsAvatar($this->name);
            if (isset($this->font) && $this->font != '' && $this->fontPath != '') {
                $initial_avatar->setFont($this->font, $this->fontPath);
            }
            $initial_avatar->setSize($this->size);
            return $initial_avatar->generate();
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

    public function setSize(int $size): void
    {
        $this->size = $size;
    }
}