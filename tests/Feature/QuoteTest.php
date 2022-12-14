<?php

namespace Feature;

use DateTimeImmutable;
use Tests\TestCase;

class QuoteTest extends TestCase
{
    /** @test */
    public function requires_certain_fields(): void
    {
        $response = $this->post(
            '/api/quote',
            [
            ]
        );
        $response->assertInvalid([
            'accountId',
            'productId',
            'dateStart',
            'covers',
        ]);
    }

    /** @test */
    public function requires_at_least_one_cover(): void
    {
        $response = $this->post(
            '/api/quote',
            [
                'accountId' => '76aa3305-aa66-4d6e-8e98-53c2c98ac2e4',
                'productId' => '2dc39bee-f308-40ae-bb7a-a81d2fc96d47',
                'dateStart' => (new DateTimeImmutable('first day of next year'))->format('Y-m-d'),
                'billingFrequency' => 'M',
                'covers' => [
                ],
            ]
        );
        $response->assertInvalid([
            'covers',
        ]);
    }

    /** @test */
    public function requires_detailed_covers(): void
    {
        $response = $this->post(
            '/api/quote',
            [
                'accountId' => '76aa3305-aa66-4d6e-8e98-53c2c98ac2e4',
                'productId' => '2dc39bee-f308-40ae-bb7a-a81d2fc96d47',
                'dateStart' => (new DateTimeImmutable('first day of next year'))->format('Y-m-d'),
                'billingFrequency' => 'M',
                'covers' => [
                    [],
                ],
            ]
        );
        $response->assertInvalid([
            'covers.0.coverId',
            'covers.0.limit',
            'covers.0.excess',
        ]);
    }

    /** @test */
    public function requires_cover_specific_fields(): void
    {
        $response = $this->post(
            '/api/quote',
            [
                'accountId' => '76aa3305-aa66-4d6e-8e98-53c2c98ac2e4',
                'productId' => '2dc39bee-f308-40ae-bb7a-a81d2fc96d47',
                'dateStart' => (new DateTimeImmutable('first day of next year'))->format('Y-m-d'),
                'billingFrequency' => 'M',
                'covers' => [
                    [
                        'coverId' => '7b573a7e-d40a-4a3a-9414-c646e9b27590',
                        'limit' => 500_000,
                        'excess' => 0,
                    ],
                ],
            ]
        );
        $response->assertInvalid([
            'covers.0.is_made_of_mostly_wood',
        ]);
    }

    /** @test */
    public function can_be_rated(): void
    {
        $response = $this->post(
            '/api/quote',
            [
                'accountId' => '76aa3305-aa66-4d6e-8e98-53c2c98ac2e4',
                'productId' => '2dc39bee-f308-40ae-bb7a-a81d2fc96d47',
                'dateStart' => (new DateTimeImmutable('first day of next year'))->format('Y-m-d'),
                'billingFrequency' => 'M',
                'covers' => [
                    [
                        'coverId' => '7b573a7e-d40a-4a3a-9414-c646e9b27590',
                        'limit' => 500_000,
                        'excess' => 0,
                        'is_made_of_mostly_wood' => false,
                    ],
                    [
                        'coverId' => '27009da6-c984-4e2c-8e9e-045adf958593',
                        'limit' => 500_000,
                        'excess' => 0,
                        'postcode' => 1234
                    ],
                ]
            ]
        );
        $response->assertJson(['premium_in_cents' => 1500_00]);
    }
}
