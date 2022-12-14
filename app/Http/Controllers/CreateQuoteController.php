<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateQuoteRequest;
use App\Models\Quote\Quote;
use App\Services\RatingService;

class CreateQuoteController extends Controller
{
    public function __invoke(CreateQuoteRequest $request, RatingService $ratingService)
    {
        $ratedQuote = $ratingService->rate(Quote::from($request));
        return [
            'quoteId' => $ratedQuote->quoteId(),
            'premium_in_cents' => $ratedQuote->premium(),
        ];
    }
}
