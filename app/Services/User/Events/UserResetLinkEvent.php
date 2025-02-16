<?php

namespace App\Services\User\Events;

use App\Services\User\Dto\UserDto;
use Illuminate\Foundation\Events\Dispatchable;

final class UserResetLinkEvent
{
    use Dispatchable;

    public function __construct(
        private readonly UserDto $userDto,
        private readonly string $resetCode,
    ) {
    }

    public function getResetCode(): string
    {
        return $this->resetCode;
    }

    public function getUserDto(): UserDto
    {
        return $this->userDto;
    }
}
