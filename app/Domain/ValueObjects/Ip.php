<?php

namespace App\Domain\ValueObjects;

use InvalidArgumentException;


final class Ip
{
    /** @var string */
    private string $ip;

    private function __construct(string $ip)
    {
        if (!filter_var($ip, FILTER_VALIDATE_IP)) {
            throw new InvalidArgumentException(
                'Ip '.$ip.' is not valid');
        }

        $this->ip = $ip;
    }

    public static function create(string $ip): Ip
    {
        return new Ip($ip);
    }

    public function value(): string
    {
        return $this->ip;
    }
}