<?php

declare(strict_types=1);

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
     * @param string $email Email for creating a hash to get the correct Avatar from Gravatar API
     */
    public function __construct(string $email)
    {
        $this->setEmail($email);
    }

    /**
     * Sets the email for Gravatar. It is used to gernerate a hash which is passed to the Gravatar API
     */
    public function setEmail(string $email): void
    {
        $this->email = $email;
        $this->setHash($email);
    }

    /**
     * Generates the hash value for the email address
     * @param $email
     */
    protected function setHash(string $email): void
    {
        $this->hash = md5(strtolower(trim($email)));
    }

    /**
     * Sets the type for the avatar.
     * @param LarvatarTypes $type All enums except LarvatarTypes::InitialsAvatar are allowed
     */
    public function setType(LarvatarTypes $type): void
    {
        if ($type == LarvatarTypes::InitialsAvatar) {
            return;
        }
        $this->type = $type;
    }

    /**
     * Sets the size of the Gravatar
     * @param int $size Size in px for the Gravatar
     */
    public function setSize(int $size): void
    {
        $this->size = $size;
    }

    /**
     * Generates and returns an HTML string containing an image tag with a Gravatar link.
     *
     * @return string The HTML string of an image tag with the Gravatar URL as the source.
     * @throws Exception
     */
    public function getHTML(): string
    {
        return '<img src="' . $this->generateGravatarLink() . '" />';
    }

    /**
     * Generate the link to the Gravatar
     * @throws Exception
     */
    public function generateGravatarLink(): string
    {
        return 'https://www.gravatar.com/avatar/' . $this->hash . $this->getAdditionalParameters();
    }

    /**
     * Depending on the selected type the missing parameters for Gravatar API will be selected
     * @throws Exception
     */
    protected function getAdditionalParameters(): string
    {
        $link = match ($this->type) {
            LarvatarTypes::Gravatar => '?d=',
            LarvatarTypes::mp => '?d=mp&f=y',
            LarvatarTypes::identicon => '?d=identicon&f=y',
            LarvatarTypes::monsterid => '?d=monsterid&f=y',
            LarvatarTypes::wavatar => '?d=wavatar&f=y',
            LarvatarTypes::retro => '?d=retro&f=y',
            LarvatarTypes::robohash => '?d=robohash&f=y',
            LarvatarTypes::InitialsAvatar => throw new Exception('Initials Avatar is not supported for Gravatars.'),
            LarvatarTypes::IdenticonLarvatar => throw new \Exception(
                'Larvatars Identicons are not supported for Gravatars.'
            )
        };
        return $link . '&s=' . $this->size;
    }
}
