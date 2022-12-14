<?php

namespace App\Services;

class PostcodeFloodingFactor
{
    public static function factorFor(int $postcode): float
    {
        if ($postcode > 1050 && $postcode < 1099) {
            return 0;
        }
        if ($postcode > 7000 && $postcode < 7083) {
            return 3;
        }
        if ($postcode > 9030 && $postcode < 9130) {
            return 0.1;
        }
        return 1;
    }
}
