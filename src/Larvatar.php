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