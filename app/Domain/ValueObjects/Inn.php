<?php

namespace App\Domain\ValueObjects;

use InvalidArgumentException;

final class Inn
{
    private string $value;

    public function __construct(string $value)
    {
        if (!filter_var($value, FILTER_VALIDATE_REGEXP, [
            'options' => [
                'regexp' => '/^\d{10,12}$/',
            ],
        ])) {
            throw new InvalidArgumentException('Invalid INN');
        }

        $this->value = $value;
    }

    public static function create(string $value): self
    {
        return new self($value);
    }

    public function value(): string
    {
        return $this->value;
    }
}
