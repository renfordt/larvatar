<?php

namespace Renfordt\Larvatar;

use Exception;
use Renfordt\Larvatar\Enum\LarvatarTypes;

class Gravatar
{

    protected LarvatarTypes $type = LarvatarTypes::mp;
    protected string $email;
    protected string $hash;
    protected int $size = 100;

    /**
     * Create a new instance of Gravatar
     * @param  string  $email  Email for creating a hash to get the correct Avatar from Gravatar API
     */
    public function __construct(string $email)
    {
        $this->setEmail($email);
    }

    /**
     * Sets the type for the avatar.
     * @param  LarvatarTypes  $type  All enums except LarvatarTypes::InitialsAvatar are allowed
     * @return void
     */
    public function setType(LarvatarTypes $type): void
    {
        if ($type == LarvatarTypes::InitialsAvatar) {
            return;
        }
        $this->type = $type;
    }

    /**
     * Sets the email for Gravatar. It is used to gernerate a hash which is passed to the Gravatar API
     * @param  string  $email
     * @return void
     */
    public function setEmail(string $email): void
    {
        $this->email = $email;
        $this->setHash($email);
    }

    /**
     * Sets the size of the Gravatar
     * @param  int  $size  Size in px for the Gravatar
     * @return void
     */
    public function setSize(int $size): void
    {
        $this->size = $size;
    }

    /**
     * Generates the hash value for the email address
     * @param $email
     * @return void
     */
    protected function setHash($email): void
    {
        $this->hash = md5(strtolower(trim($email)));
    }

    /**
     * Depending on the selected type the missing parameters for Gravatar API will be selected
     * @return string
     * @throws Exception
     */
    protected function getAdditionalParameters(): string
    {
        $link = match($this->type) {
            LarvatarTypes::Gravatar => '?d=',
            LarvatarTypes::mp => '?d=mp&f=y',
            LarvatarTypes::identicon => '?d=identicon&f=y',
            LarvatarTypes::monsterid => '?d=monsterid&f=y',
            LarvatarTypes::wavatar => '?d=wavatar&f=y',
            LarvatarTypes::retro => '?d=retro&f=y',
            LarvatarTypes::robohash => '?d=robohash&f=y',
            LarvatarTypes::InitialsAvatar => throw new Exception('Initials Avatar is not supportet for Gravatars.')
        };
        return $link.'&s='.$this->size;
    }

    /**
     * Generate the link to the Gravatar
     * @return string
     */
    public function generateGravatarLink(): string
    {
        return 'https://www.gravatar.com/avatar/'.$this->hash.$this->getAdditionalParameters();
    }
}
