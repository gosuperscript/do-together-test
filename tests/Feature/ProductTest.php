<?php

namespace Feature;

use Tests\TestCase;

class ProductTest extends TestCase
{
    /** @test */
    public function can_be_retrieved_in_a_list(): void
    {
        $expected = [
            [
                'productId' => '2dc39bee-f308-40ae-bb7a-a81d2fc96d47',
                'name' => 'Homeowners insurance',
                'covers' => [
                    [
                        'coverId' => '7b573a7e-d40a-4a3a-9414-c646e9b27590',
                        'name' => 'Fire insurance',
                        'fields' => [
                            'limit',
                            'excess',
                            'is_made_of_mostly_wood',
                        ],
                    ],
                    [
                        'coverId' => '27009da6-c984-4e2c-8e9e-045adf958593',
                        'name' => 'Flooding insurance',
                        'fields' => [
                            'limit',
                            'excess',
                            'postcode',
                        ],
                    ],
                ]
            ]
        ];
        $actual = $this->get('/api/product')->json();
        $this->assertEquals($expected, $actual);
    }
}
