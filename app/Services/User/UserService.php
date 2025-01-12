<?php

namespace App\Services\User;

use App\Services\User\Dto\CreateUserDto;
use App\Services\User\Dto\UpdateUserDto;
use App\Services\User\Dto\UserDto;
use Ramsey\Uuid\UuidInterface;

interface UserService
{
    /**
     * @param  UuidInterface  $userId
     * @return UserDto
     */
    public function find(UuidInterface $userId): UserDto;

    public function delete(UuidInterface $userId): bool;

    public function create(CreateUserDto $createUserDto);

    public function update(UpdateUserDto $updateUserDto);

    public function getCompanyIds(UuidInterface $userId);

    public function firstUserInCompany(UuidInterface $companyId);

    public function appendCompanyToUser(UuidInterface $companyId, UuidInterface $userId):void;

}