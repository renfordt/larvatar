<?php

declare(strict_types=1);

namespace Renfordt\Larvatar\Tests;

use Renfordt\Larvatar\Enum\LarvatarTypes;
use Renfordt\Larvatar\Traits\LarvatarTrait;

class User
{
    use LarvatarTrait;

    public string $name;
    public string $email;
    public LarvatarTypes $type;

    /**
     * Generate and retrieve the avatar URL or HTML for the user.
     *
     * @param int $size The size of the avatar in pixels.
     * @param bool $encoding Whether to return the encoded image as HTML.
     * @return string The avatar as a string URL or encoded HTML.
     */
    public function getAvatar(int $size = 100, bool $encoding = true): string
    {
        $larvatar = $this->getLarvatar($this->name, $this->email);
        $larvatar->setSize($size);
        $larvatar->setWeight('600');
        return $larvatar->getImageHTML(true);
    }
}
