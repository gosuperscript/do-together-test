<?php

namespace Unit;

use App\Models\Quote\BillingFrequency;
use App\Models\Quote\Cover;
use App\Models\Quote\Quote;
use App\Services\RatingService;
use DateTimeImmutable;
use PHPUnit\Framework\TestCase;
use Ramsey\Uuid\Uuid;

class RatingServiceTest extends TestCase
{
    /** @test */
    public function rates_a_single_cover(): void
    {
        $quote = $this->quoteFor([
            new Cover(
                Uuid::fromString('7b573a7e-d40a-4a3a-9414-c646e9b27590'),
                [
                    'limit' => 500_000,
                    'excess' => 0,
                    'is_made_of_mostly_wood' => false,
                ]
            )
        ]);
        $expected = 500_00;

        $actual = (new RatingService())->rate($quote)->premium();

        $this->assertEquals($expected, $actual);
    }

    /** @test */
    public function rates_double_for_fire_insurance_if_house_is_made_of_mostly_wood(): void
    {
        $quote = $this->quoteFor([
            new Cover(
                Uuid::fromString('7b573a7e-d40a-4a3a-9414-c646e9b27590'),
                [
                    'limit' => 500_000,
                    'excess' => 0,
                    'is_made_of_mostly_wood' => true,
                ]
            )
        ]);
        $expected = 1000_00;

        $actual = (new RatingService())->rate($quote)->premium();

        $this->assertEquals($expected, $actual);
    }

    /** @test */
    public function cannot_rate_flooding_insurance_for_homes_near_the_sea(): void
    {
        $quote = $this->quoteFor([
            new Cover(
                Uuid::fromString('27009da6-c984-4e2c-8e9e-045adf958593'),
                [
                    'limit' => 500_000,
                    'excess' => 0,
                    'postcode' => 1051, // a typical ocean-side property
                ]
            )
        ]);
        $expected = 0;

        $actual = (new RatingService())->rate($quote)->premium();

        $this->assertEquals($expected, $actual);
    }

    /** @test */
    public function rates_triple_for_flooding_insurance_for_homes_near_river_banks(): void
    {
        $quote = $this->quoteFor([
            new Cover(
                Uuid::fromString('27009da6-c984-4e2c-8e9e-045adf958593'),
                [
                    'limit' => 500_000,
                    'excess' => 0,
                    'postcode' => 7022, // a typical bank-side property
                ]
            )
        ]);
        $expected = 3000_00;

        $actual = (new RatingService())->rate($quote)->premium();

        $this->assertEquals($expected, $actual);
    }

    /** @test */
    public function rates_one_tenth_for_flooding_insurance_for_homes_uphill(): void
    {
        $quote = $this->quoteFor([
            new Cover(
                Uuid::fromString('27009da6-c984-4e2c-8e9e-045adf958593'),
                [
                    'limit' => 500_000,
                    'excess' => 0,
                    'postcode' => 9099, // a typical hill-side property
                ]
            )
        ]);
        $expected = 100_00;

        $actual = (new RatingService())->rate($quote)->premium();

        $this->assertEquals($expected, $actual);
    }

    private function quoteFor(array $covers): Quote
    {
        return new Quote(
            Uuid::uuid4(),
            Uuid::uuid4(),
            Uuid::uuid4(),
            new DateTimeImmutable(),
            BillingFrequency::Yearly,
            $covers
        );
    }
}
