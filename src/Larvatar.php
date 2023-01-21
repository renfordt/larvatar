<?php

namespace Renfordt\Larvatar;

use Renfordt\Larvatar\Enum\LarvatarTypes;

class Larvatar
{
    protected LarvatarTypes $type = LarvatarTypes::mp;
    protected string $name;
    protected string $email;
    protected string $font;
    protected string $font_path;

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

    public function getImageHTML()
    {
        if ($this->type == LarvatarTypes::InitialsAvatar) {
            $initial_avatar = new InitialsAvatar($this->name);
            if (isset($this->font) && $this->font != '' && $this->font_path != '') {
                $initial_avatar->setFont($this->font, $this->font_path);
            }
            return $initial_avatar->generate();
        }

        $gravatar = new Gravatar($this->email);
        $gravatar->setType($this->type);
        return '<img src="'.$gravatar->generateGravatarLink().'" />';
    }

    public function setFont(string $font_family, string $path): void
    {
        $this->font = $font_family;
        $this->font_path = $path;
    }

}