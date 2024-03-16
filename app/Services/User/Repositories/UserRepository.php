<?php

namespace App\Services\User\Repositories;

use App\Domain\ValueObjects\Email;
use App\Domain\ValueObjects\Phone;
use App\Domain\ValueObjects\Photo;
use App\Models\User;
use App\Services\User\Dto\UserDto;
use Carbon\Carbon;
use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;


final class UserRepository
{
    public function find(UuidInterface $userId): UserDto
    {
        $user = User::findOrFail($userId);

        return $this->formatUserDto($user);
    }

    private function formatUserDto(User $user): UserDto
    {
        return new UserDto(
            id: Uuid::fromString($user->uuid),
            firstName: $user->first_name,
            lastName: $user->last_name,
            secondName: $user->second_name,
            phone: Phone::create($user->phone),
            photo: Photo::create(asset($user->avatar), $this->getFullName($user->first_name, $user->last_name)),
            email: Email::create($user->email),
            yandexId: $user->yandex_id,
            birthday: Carbon::create($user->birthday),
            createdAt: Carbon::create($user->created_at),
        );
    }

    private function getFullName(string $firstName, string $lastName): string
    {
        return $firstName.$lastName;
    }
}
