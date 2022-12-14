<?php

namespace App\Models\Quote;

use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;

class Cover
{
    private UuidInterface $coverId;
    private array $inputs;

    public function __construct(UuidInterface $coverId, array $inputs)
    {
        $this->coverId = $coverId;
        $this->inputs = $inputs;
    }

    public static function from(array $cover): self
    {
        $coverId = Uuid::fromString($cover['coverId']);
        unset($cover['coverId']);
        return new self($coverId, $cover);
    }

    public function getCoverId(): UuidInterface
    {
        return $this->coverId;
    }

    public function getInputs(): array
    {
        return $this->inputs;
    }
}
