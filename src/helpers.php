<?php

if (! function_exists('clamp')) {
    /**
     * Clamp a number between a minimum and maximum value.
     *
     * @param  int|float  $num  The number to clamp.
     * @param  int|float  $min  The minimum value.
     * @param  int|float  $max  The maximum value.
     * @return int|float  The clamped number.
     */
    function clamp(int|float $num, int|float $min, int|float $max): int|float
    {
        if ($num > $max) {
            $num = $max;
        } elseif ($num < $min) {
            $num = $min;
        }
        return $num;
    }
}