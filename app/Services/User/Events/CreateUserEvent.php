<?php

namespace App\Services\User\Events;

use Illuminate\Foundation\Events\Dispatchable;
use Ramsey\Uuid\UuidInterface;

class CreateUserEvent
{
    use Dispatchable;

    public function __construct(
        private readonly UuidInterface $userId,
    ) {
    }

    public function getUserId(): UuidInterface
    {
        return $this->userId;
    }
}
