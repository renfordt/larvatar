<?php

namespace Renfordt\Larvatar\Traits;

use Renfordt\Larvatar\Enum\LarvatarTypes;
use Renfordt\Larvatar\Larvatar;

trait LarvatarTrait
{
    /**
     * Generates an avatar image based on the provided parameters.
     *
     * @param string $name The name to be used for generating the avatar.
     * @param string $email Optional email to be used for generating the avatar.
     * @param int $size The size of the avatar image.
     * @param LarvatarTypes $type The type of avatar to generate.
     * @param bool $encoding Whether to encode the image in base64.
     *
     * @return string The generated avatar image in HTML format.
     */
    public function getAvatar(string $name, string $email = '', int $size = 100, LarvatarTypes $type = LarvatarTypes::InitialsAvatar, bool $encoding = false): string
    {
        $larvatar = new Larvatar($type, $name, $email);
        $larvatar->setSize($size);
        return $larvatar->getImageHTML($encoding);
    }
}
