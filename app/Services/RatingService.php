<?php

namespace App\Services;

use App\Models\Quote\Cover;
use App\Models\Quote\Quote;
use App\Models\Quote\RatedQuote;

/**
 * The rating service would normally be a separate microservice
 */
class RatingService
{
    public function rate(Quote $quote): RatedQuote
    {
        $premiums = array_map(
            fn(Cover $cover) => $this->rateCover($cover),
            $quote->covers()
        );
        return new RatedQuote($quote, array_sum($premiums));
    }

    private function rateCover(Cover $cover): float
    {
        switch ($cover->getCoverId()->toString()) {
            case '7b573a7e-d40a-4a3a-9414-c646e9b27590':
                return 0.1 * $cover->getInputs()['limit']
                    * ($cover->getInputs()['is_made_of_mostly_wood'] ? 2 : 1);
            case '27009da6-c984-4e2c-8e9e-045adf958593':
                return 0.2 * $cover->getInputs()['limit'] * PostcodeFloodingFactor::factorFor($cover->getInputs()['postcode']);
        }
        return 0;
    }
}
