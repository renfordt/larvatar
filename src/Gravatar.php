<?php

namespace Renfordt\Larvatar;

use Renfordt\Larvatar\Enum\LarvatarTypes;

class Gravatar
{

    protected LarvatarTypes $type = LarvatarTypes::mp;
    protected string $email;
    protected string $hash;
    protected int $size;

    public function __construct(string $email)
    {
        $this->setEmail($email);
    }

    public function setType(LarvatarTypes $type): void
    {
        $this->type = $type;
    }

    public function setEmail(string $email): void
    {
        $this->email = $email;
        $this->setHash($email);
    }

    public function setSize(int $size): void
    {
        $this->size = $size;
    }

    protected function setHash($email): void
    {
        $this->hash = md5(strtolower(trim($email)));
    }

    protected function getDefaultKey(): string
    {
        $link = match ($this->type) {
            LarvatarTypes::Gravatar => '?d=',
            LarvatarTypes::mp => '?d=mp&f=y',
            LarvatarTypes::identicon => '?d=identicon&f=y',
            LarvatarTypes::monsterid => '?d=monsterid&f=y',
            LarvatarTypes::wavatar => '?d=wavatar&f=y',
            LarvatarTypes::retro => '?d=retro&f=y',
            LarvatarTypes::robohash => '?d=robohash&f=y'
        };
        return $link.$this->size ? '&s='.$this->size : '';
    }

    /**
     * Generate the link to the Gravatar
     * @return string
     */
    public function generateGravatarLink(): string
    {
        return 'https://www.gravatar.com/avatar/'.$this->hash.$this->getDefaultKey();
    }
}