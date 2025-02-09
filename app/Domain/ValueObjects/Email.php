<?php

namespace App\Domain\ValueObjects;

use InvalidArgumentException;

final class Email
{
    /** @var string */
    private string $email;

    private function __construct(string $email)
    {
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {

            throw new InvalidArgumentException(
                'Email '.$email.' is not valid');

        }

        $this->email = $email;
    }

    public static function create(string $email): Email
    {
        return new Email($email);
    }

    public function value(): string
    {
        return $this->email;
    }
}