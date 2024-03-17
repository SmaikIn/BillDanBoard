<?php

namespace App\Services\User\Repositories;

use App\Domain\ValueObjects\Email;
use App\Domain\ValueObjects\Phone;
use App\Domain\ValueObjects\Photo;
use App\Models\User;
use App\Services\User\Dto\CreateUserDto;
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

    public function delete(UuidInterface $userId): bool
    {
        $user = User::where('uuid', $userId->toString())->firstOrFail();

        return $user->delete();
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
