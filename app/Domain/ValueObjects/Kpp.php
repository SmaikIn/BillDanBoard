<?php

namespace App\Domain\ValueObjects;

use InvalidArgumentException;


final class Kpp
{
    private string $value;

    public function __construct(string $value)
    {
        if (!filter_var($value, FILTER_VALIDATE_REGEXP, [
            'options' => [
                'regexp' => '/^\d{10}$/',
            ],
        ])) {
            throw new InvalidArgumentException('Invalid KPP');
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
