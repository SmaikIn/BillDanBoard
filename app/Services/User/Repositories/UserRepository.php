<?php

namespace App\Services\User\Repositories;

use App\Domain\ValueObjects\Email;
use App\Domain\ValueObjects\Phone;
use App\Domain\ValueObjects\Photo;
use App\Models\User;
use App\Services\User\Dto\CreateUserDto;
use App\Services\User\Dto\UpdateUserDto;
use App\Services\User\Dto\UserDto;
use Carbon\Carbon;
use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;


final class UserRepository
{
    public function find(UuidInterface $userId): UserDto
    {
        $user = User::where('uuid', $userId->toString())->firstOrFail();

        return $this->formatUserDto($user);
    }

    public function create(CreateUserDto $createUserDto): UserDto
    {
        $user = new User;
        $user->uuid = Uuid::uuid4()->toString();
        $user->first_name = $createUserDto->getFirstName();
        $user->last_name = $createUserDto->getLastName();
        $user->second_name = $createUserDto->getSecondName();
        $user->phone = is_null($createUserDto->getPhone()) ? $createUserDto->getPhone() : $createUserDto->getPhone()->value();
        $user->password = \Hash::make($createUserDto->getPassword()->value());
        $user->avatar = $createUserDto->getPhoto();
        $user->email = $createUserDto->getEmail()->value();
        $user->yandex_id = $createUserDto->getYandexId();
        $user->birthday = is_null($createUserDto->getBirthday()) ? $createUserDto->getBirthday() : $createUserDto->getBirthday()->toString();

        $user->save();

        return $this->formatUserDto($user);
    }

    public function update(UpdateUserDto $updateUserDto): UserDto
    {
        $user = User::where('uuid', $updateUserDto->getId()->toString())->firstOrFail();

        $user->first_name = $updateUserDto->getFirstName();
        $user->last_name = $updateUserDto->getLastName();
        $user->second_name = $updateUserDto->getSecondName();
        $user->phone = is_null($updateUserDto->getPhone()) ? $updateUserDto->getPhone() : $updateUserDto->getPhone()->value();
        $user->avatar = $updateUserDto->getPhoto();
        $user->email = $updateUserDto->getEmail()->value();
        $user->birthday = is_null($updateUserDto->getBirthday()) ? $updateUserDto->getBirthday() : $updateUserDto->getBirthday()->toString();
        $user->updated_at = now();

        $user->save();

        return $this->formatUserDto($user);
    }

    public function delete(UuidInterface $userId): bool
    {
        $user = User::where('uuid', $userId->toString())->firstOrFail();

        return $user->delete();
    }

    /**
     * @param  UuidInterface  $userId
     * @return string[]
     */
    public function getCompanyIds(UuidInterface $userId): array
    {
        $user = User::where('uuid', $userId->toString())->firstOrFail();

        return $user->companies->pluck('uuid')->toArray();
    }

    /**
     * @param  UuidInterface  $companyId
     * @return UserDto
     */
    public function firstUserInCompany(UuidInterface $companyId): UserDto
    {
        $dbUser = User::whereHas('companies', function ($query) use ($companyId) {
            $query->where('uuid', $companyId->toString());
        })->first();

        return $this->formatUserDto($dbUser);
    }

    private function formatUserDto(User $user): UserDto
    {
        return new UserDto(
            id: Uuid::fromString($user->uuid),
            firstName: $user->first_name,
            lastName: $user->last_name,
            secondName: $user->second_name,
            phone: is_null($user->phone) ? null : Phone::create($user->phone),
            photo: Photo::create(asset($user->avatar), $this->getFullName($user->first_name, $user->last_name)),
            email: Email::create($user->email),
            yandexId: $user->yandex_id,
            birthday: is_null($user->birthday) ? $user->birthday : Carbon::create($user->birthday),
            createdAt: Carbon::create($user->created_at),
        );
    }

    private function getFullName(string $firstName, string $lastName): string
    {
        return $firstName.$lastName;
    }
}
