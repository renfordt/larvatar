<?php

declare(strict_types=1);

namespace Renfordt\Larvatar\Traits;

use Renfordt\Larvatar\Enum\LarvatarTypes;
use Renfordt\Larvatar\Larvatar;

trait LarvatarTrait
{
    /**
     * Generates a Larvatar instance based on the provided name, email, and type.
     *
     * @param string $name The name to be used for the Larvatar generation.
     * @param string $email Optional email address to associate with the Larvatar. Defaults to an empty string.
     * @param LarvatarTypes $type The type of Larvatar to generate. Defaults to LarvatarTypes::InitialsAvatar.
     * @return Larvatar The generated Larvatar instance.
     */
    public function getLarvatar(
        string $name,
        string $email = '',
        LarvatarTypes $type = LarvatarTypes::InitialsAvatar
    ): Larvatar {
        return new Larvatar($type, $name, $email);
    }

    abstract public function getAvatar(int $size = 100, bool $encoding = true);
}
