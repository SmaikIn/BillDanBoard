<?php

namespace App\Domain\ValueObjects;

use InvalidArgumentException;

final class Password
{
    /** @var string */
    private string $password;

    private function __construct(string $password)
    {
        if (!(strlen($password) > 7 && strlen($password) < 255)) {
            throw new InvalidArgumentException(
                'Password '.$password.' is not valid');
        }

        $this->password = $password;
    }

    public static function create(string $password): Password
    {
        return new Password($password);
    }

    public function value(): string
    {
        return $this->password;
    }
}
