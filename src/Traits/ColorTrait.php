<?php

namespace Renfordt\Larvatar\Traits;

use Renfordt\Larvatar\Name;

trait ColorTrait
{
    /**
     * Get the color set for a given name.
     *
     * @param  Name  $name  The name to get the color set for.
     * @param  float  $textLightness  The lightness value for the text color. Default is 0.35.
     * @param  float  $backgroundLightness  The lightness value for the background color. Default is 0.8.
     * @return array An array containing the dark and light colors in HSL format.
     */
    public function getColorSet(Name $name, float $textLightness = 0.35, float $backgroundLightness = 0.8): array
    {
        $color = $name->getHexColor();

        $dark = $color->toHSL();
        $dark->setLightness($textLightness);
        $light = $color->toHSL();
        $light->setLightness($backgroundLightness);
        return [$dark, $light];
    }

}