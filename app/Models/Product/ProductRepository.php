<?php

namespace App\Models\Product;

use Ramsey\Uuid\Uuid;

class ProductRepository
{
    private array $products;

    public function __construct()
    {
        $this->products = [
            new Product(
                Uuid::fromString('2dc39bee-f308-40ae-bb7a-a81d2fc96d47'),
                'Homeowners insurance',
                [
                    new Cover(
                        Uuid::fromString('7b573a7e-d40a-4a3a-9414-c646e9b27590'),
                        'Fire insurance',
                        ['is_made_of_mostly_wood']
                    ),
                    new Cover(
                        Uuid::fromString('27009da6-c984-4e2c-8e9e-045adf958593'),
                        'Flooding insurance',
                        ['postcode']
                    ),
                ]
            ),
        ];
    }

    public function products(): array
    {
        return $this->products;
    }
}
