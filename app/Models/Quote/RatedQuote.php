<?php

namespace App\Models\Quote;

use Ramsey\Uuid\UuidInterface;

class RatedQuote
{
    public function __construct(private readonly Quote $quote, private readonly float $premium)
    {
    }

    public function quote(): Quote
    {
        return $this->quote;
    }

    public function quoteId(): UuidInterface
    {
        return $this->quote->quoteId();
    }

    public function premium(): float
    {
        return $this->premium;
    }
}
