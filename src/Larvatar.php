<?php

namespace Renfordt\Larvatar;

use Renfordt\Larvatar\Enum\LarvatarTypes;

class Larvatar
{
    protected LarvatarTypes $type = LarvatarTypes::mp;
    protected string $name;
    protected string $email;

    public function getImage()
    {
        if ($this->type == LarvatarTypes::InitialsAvatar) {
            $initial_avatar = new InitialsAvatar($this->name);
            return $initial_avatar->generate();
        }

        $gravatar = new Gravatar($this->email);
        $gravatar->setType($this->type);
        return $gravatar->generateGravatarLink();
    }

    public function __construct(string $name, string $email, int|LarvatarTypes $type)
    {
        $this->name = $name;
        $this->email = $email;
        if (is_int($type)) {
            $this->type = LarvatarTypes::from($type);
        } elseif ($type instanceof LarvatarTypes) {
            $this->type = $type;
        }
    }

}