<?php

namespace App\Services\User;

use App\Domain\ValueObjects\Email;
use App\Domain\ValueObjects\Password;
use App\Services\User\Dto\CreateUserDto;
use App\Services\User\Dto\ResetPasswordDto;
use App\Services\User\Dto\UpdateUserDto;
use App\Services\User\Dto\UserDto;
use App\Services\User\Events\CreateUserEvent;
use App\Services\User\Events\UserResetLinkEvent;
use App\Services\User\Repositories\UserRepository;
use Illuminate\Contracts\Cache\Repository as CacheInterface;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Str;
use Ramsey\Uuid\UuidInterface;

final readonly class UserService
{
    public function __construct(
        private UserRepository $userRepository,
        private CacheInterface $cache,
    ) {
    }

    public function find(UuidInterface $userId): UserDto
    {
        return $this->userRepository->find($userId);
    }

    public function findByEmail(Email $email): UserDto
    {
        return $this->userRepository->findByEmail($email);
    }

    public function forgotPassword(Password $password, string $code): ?UserDto
    {
        $key = sprintf(config('cache.keys.user.reset-link'), $code);

        /** @var ResetPasswordDto $dto */
        $dto = $this->cache->get($key);

        if (!$dto) {
            return null;
        }

        $this->userRepository->changeUserPassword($dto->getUserId(), $password->value());

        $this->cache->forget($key);

        return $this->userRepository->find($dto->getUserId());
    }

    public function sendResetLink(UserDto $userDto): void
    {
        $code = Str::random(60);

        $key = sprintf(config('cache.keys.user.reset-link'), $code);

        $dto = new ResetPasswordDto(
            $userDto->getId(),
            $code
        );

        $this->cache->set($key, $dto, Carbon::parse('1 hour'),);

        Event::dispatch(new UserResetLinkEvent($userDto, $code));
    }

    public function delete(UuidInterface $userId): bool
    {
        return $this->userRepository->delete($userId);
    }

    public function create(CreateUserDto $createUserDto)
    {
        $user = $this->userRepository->create($createUserDto);

        Event::dispatch(new CreateUserEvent($user->getId()));

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
