<?php

declare(strict_types=1);

namespace App\Services\Auth;

use App\Services\Auth\Dto\AuthAttemptDto;
use App\Services\Auth\Dto\JWTDto;
use App\Services\Auth\Dto\PayloadJWTDto;

interface AuthService
{
    public function getPayloadFromToken(string $token): PayloadJWTDto;

    public function attempt(AuthAttemptDto $dto): ?JWTDto;

    public function logout(): void;

    public function refresh(): ?JWTDto;
}