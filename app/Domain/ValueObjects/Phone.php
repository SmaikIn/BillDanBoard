<?php

namespace App\Domain\ValueObjects;

use InvalidArgumentException;

final class Phone
{
    /** @var string */
    private string $phone;

    private function __construct(string $phone)
    {
        if (!preg_match('%^(?:(?:\(?(?:00|\+)([1-4]\d\d|[1-9]\d?)\)?)?[\-\.\ \\\/]?)?((?:\(?\d{1,}\)?[\-\.\ \\\/]?){0,})(?:[\-\.\ \\\/]?(?:#|ext\.?|extension|x)[\-\.\ \\\/]?(\d+))?$%i',
                $phone) && strlen($phone) >= 10) {
            throw new InvalidArgumentException(
                'Phone '.$phone.' is not valid');
        }

        $this->phone = $phone;
    }

    public static function create(string $phone): Phone
    {
        return new Phone($phone);
    }

    public function value(): string
    {
        return $this->phone;
    }
}
