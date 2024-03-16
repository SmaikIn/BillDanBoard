<?php

declare(strict_types=1);

namespace App\Services\Auth\Dto;

use App\Domain\ValueObjects\Email;
use App\Domain\ValueObjects\Password;

final readonly class AuthAttemptDto
{
    public function __construct(
        private Email $email,
        private Password $password,
    ) {
    }

    public function getEmail(): Email
    {
        return $this->email;
    }

    public function getPassword(): Password
    {
        return $this->password;
    }
}