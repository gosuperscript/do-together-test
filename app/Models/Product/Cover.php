<?php

namespace App\Models\Product;

use Ramsey\Uuid\UuidInterface;

class Cover
{
    private UuidInterface $coverId;
    private string $name;
    /** @var string[] */
    private array $fields;

    /**
     * @param UuidInterface $coverId
     * @param string $name
     * @param string[] $fields
     */
    public function __construct(UuidInterface $coverId, string $name, array $fields)
    {
        $this->coverId = $coverId;
        $this->name = $name;
        $this->fields = array_merge(
            ['limit', 'excess'],
            $fields
        );
    }

    public function toArray(): array
    {
        return [
            'coverId' => $this->coverId->toString(),
            'name' => $this->name,
            'fields' => $this->fields,
        ];
    }
}
