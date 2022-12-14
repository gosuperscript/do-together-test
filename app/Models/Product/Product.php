<?php

namespace App\Models\Product;

use Ramsey\Uuid\UuidInterface;

class Product
{
    private UuidInterface $productId;
    private string $name;
    /** @var Cover[] */
    private array $covers;

    /**
     * @param UuidInterface $productId
     * @param string $name
     * @param Cover[] $covers
     */
    public function __construct(
        UuidInterface $productId,
        string $name,
        array $covers
    )
    {
        $this->productId = $productId;
        $this->name = $name;
        $this->covers = $covers;
    }

    public function toArray(): array
    {
        return [
            'productId' => $this->productId->toString(),
            'name' => $this->name,
            'covers' => array_map(
                fn(Cover $cover) => $cover->toArray(),
                $this->covers
            ),
        ];
    }
}
