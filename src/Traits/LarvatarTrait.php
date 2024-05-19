<?php

namespace Renfordt\Larvatar\Traits;

use Renfordt\Larvatar\Enum\LarvatarTypes;
use Renfordt\Larvatar\Larvatar;

trait LarvatarTrait
{
    /**
     * Retrieves the avatar image HTML based on the provided name, email, avatar type, and encoding.
     *
     * @param  string  $name  The name used to generate the avatar.
     * @param  string  $email  The email address used to generate the avatar.
     * @param  LarvatarTypes  $type  The type of avatar to generate. Default is initial avatars.
     * @param  string  $encoding  The encoding type for the avatar image. Default is empty string.
     * @return string The HTML representation of the avatar image.
     */
    public function getAvatar(string $name, string $email = '', int $size = 100, LarvatarTypes $type = LarvatarTypes::InitialsAvatar, bool $encoding = false): string
    {
        $larvatar = new Larvatar($type, $name, $email);
        $larvatar->setSize($size);
        $larvatar->setFont('Roboto,sans-serif', '/font/Roboto-Bold.ttf');
        return $larvatar->getImageHTML($encoding);
    }
}