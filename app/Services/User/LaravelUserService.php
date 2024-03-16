<?php

namespace App\Services\User;

use App\Services\User\Dto\UserDto;
use App\Services\User\Repositories\UserRepository;
use Ramsey\Uuid\UuidInterface;

final readonly class LaravelUserService implements UserService
{
    public function __construct(
        //private Dispatcher $dispatcher,
        private UserRepository $userRepository,
    ) {
    }

    public function find(UuidInterface $userId): UserDto
    {
        return $this->userRepository->find($userId);
    }
}
