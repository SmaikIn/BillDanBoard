<?php

namespace App\Services\User\Dto;


use Ramsey\Uuid\UuidInterface;

final readonly class ResetPasswordDto
{
    public function __construct(
        private UuidInterface $userId,
        private string $code,
    ) {
    }

    public function getUserId(): UuidInterface
    {
        return $this->userId;
    }

    public function getCode(): string
    {
        return $this->code;
    }

}