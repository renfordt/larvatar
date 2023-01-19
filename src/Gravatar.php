<?php

namespace Renfordt\Larvatar;

class Gravatar
{
    /**
     * Get the link to the Gravatar
     * @param  string  $email
     * @return string
     */
    public static function GetGravatarLink(string $email): string
    {
        $hash = md5(strtolower(trim($email)));
        return "http://www.gravatar.com/avatar/$hash";
    }
}