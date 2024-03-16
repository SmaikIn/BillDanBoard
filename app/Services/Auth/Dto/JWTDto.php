<?php

declare(strict_types=1);

namespace App\Services\Auth\Dto;

final readonly class JWTDto
{
    public function __construct(
        private string $token,
        private string $type,
        private PayloadJWTDto $payload,
    ) {
    }

    public function getToken(): string
    {
        return $this->token;
    }

    public function getType(): string
    {
        return $this->type;
    }

    public function getPayload(): PayloadJWTDto
    {
        return $this->payload;
    }
}