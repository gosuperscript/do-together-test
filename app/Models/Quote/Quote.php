<?php

namespace App\Models\Quote;

use App\Http\Requests\CreateQuoteRequest;
use DateTimeImmutable;
use Ramsey\Uuid\Rfc4122\UuidV4;
use Ramsey\Uuid\UuidInterface;

class Quote
{
    private UuidInterface $quoteId;
    private UuidInterface $accountId;
    private UuidInterface $productId;
    private DateTimeImmutable $dateStart;
    private BillingFrequency $billingFrequency;
    /** @var Cover[] */
    private array $covers;

    /**
     * @param UuidInterface $quoteId
     * @param UuidInterface $accountId
     * @param UuidInterface $productId
     * @param DateTimeImmutable $dateStart
     * @param BillingFrequency $billingFrequency
     * @param Cover $covers
     */
    public function __construct(
        UuidInterface $quoteId,
        UuidInterface $accountId,
        UuidInterface $productId,
        DateTimeImmutable $dateStart,
        BillingFrequency $billingFrequency,
        array $covers
    )
    {
        $this->quoteId = $quoteId;
        $this->accountId = $accountId;
        $this->productId = $productId;
        $this->dateStart = $dateStart;
        $this->billingFrequency = $billingFrequency;
        $this->covers = $covers;
    }

    public static function from(CreateQuoteRequest $request): self
    {
        return new self(
            UuidV4::uuid4(),
            UuidV4::fromString($request->get('accountId')),
            UuidV4::fromString($request->get('productId')),
            new DateTimeImmutable($request->get('dateStart')),
            BillingFrequency::from($request->get('billingFrequency')),
            array_map(
                fn(array $cover) => Cover::from($cover),
                $request->get('covers')
            )
        );
    }

    public function quoteId(): UuidInterface
    {
        return $this->quoteId;
    }

    /**
     * @return Cover[]
     */
    public function covers(): array
    {
        return $this->covers;
    }
}
