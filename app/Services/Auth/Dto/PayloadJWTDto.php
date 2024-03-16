<?php

declare(strict_types=1);

namespace App\Services\Auth\Dto;

use Carbon\Carbon;
use Ramsey\Uuid\UuidInterface;

final readonly class PayloadJWTDto
{
    public function __construct(
        private UuidInterface $userId,
        private Carbon $expires,
    ) {
    }

    public function getUserId(): UuidInterface
    {
        return $this->userId;
    }

    public function getExpires(): Carbon
    {
        return $this->expires;
    }
}