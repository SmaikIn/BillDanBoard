<?php

namespace App\Services\User;

use App\Services\User\Dto\CreateUserDto;
use App\Services\User\Dto\UpdateUserDto;
use App\Services\User\Dto\UserDto;
use App\Services\User\Events\CreateUserEvent;
use App\Services\User\Repositories\UserRepository;
use Illuminate\Contracts\Events\Dispatcher;
use Ramsey\Uuid\UuidInterface;

final readonly class LaravelUserService implements UserService
{
    public function __construct(
        private Dispatcher $dispatcher,
        private UserRepository $userRepository,
    ) {
    }

    public function find(UuidInterface $userId): UserDto
    {
        return $this->userRepository->find($userId);
    }

    public function delete(UuidInterface $userId): bool
    {
        return $this->userRepository->delete($userId);
    }

    public function create(CreateUserDto $createUserDto)
    {
        $user = $this->userRepository->create($createUserDto);

        $this->dispatcher->dispatch(new CreateUserEvent($user->getId()));

        return $user;
    }

    public function update(UpdateUserDto $updateUserDto): UserDto
    {
        return $this->userRepository->update($updateUserDto);
    }

    /**
     * @param  UuidInterface  $userId
     * @return string[]
     */
    public function getCompanyIds(UuidInterface $userId): array
    {
        return $this->userRepository->getCompanyIds($userId);
    }

    /**
     * @param  UuidInterface  $companyId
     * @return UserDto
     */
    public function firstUserInCompany(UuidInterface $companyId): UserDto
    {
        return $this->userRepository->firstUserInCompany($companyId);
    }

    public function appendCompanyToUser(UuidInterface $companyId, UuidInterface $userId): void
    {
        $this->userRepository->appendCompanyToUser($companyId, $userId);
    }
}
