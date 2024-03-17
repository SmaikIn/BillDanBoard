<?php

namespace App\Services\User;

use App\Services\User\Dto\CreateUserDto;
use App\Services\User\Dto\UserDto;
use Ramsey\Uuid\UuidInterface;

interface UserService
{
    /**
     * @param  UuidInterface  $userId
     * @return UserDto
     */
    public function find(UuidInterface $userId): UserDto;

    public function create(CreateUserDto $createUserDto);

}