<?php

declare(strict_types=1);

namespace App\Dto;

use App\Domain\ValueObjects\Email;
use App\Domain\ValueObjects\Phone;
use App\Domain\ValueObjects\Photo;
use Carbon\Carbon;
use Ramsey\Uuid\UuidInterface;

final readonly class UserDto
{
    public function __construct(
        private UuidInterface $id,
        private string $firstName,
        private string $lastName,
        private ?string $secondName,
        private ?Phone $phone,
        private Photo $photo,
        private Email $email,
        private ?string $yandexId,
        private ?Carbon $birthday,
        private Carbon $createdAt
    ) {
    }

    public function getId(): UuidInterface
    {
        return $this->id;
    }

    public function getFirstName(): string
    {
        return $this->firstName;
    }

    public function getLastName(): string
    {
        return $this->lastName;
    }

    public function getSecondName(): ?string
    {
        return $this->secondName;
    }

    public function getPhone(): ?Phone
    {
        return $this->phone;
    }

    public function getPhoto(): Photo
    {
        return $this->photo;
    }

    public function getEmail(): Email
    {
        return $this->email;
    }
    public function getYandexId(): ?string
    {
        return $this->yandexId;
    }

    public function getBirthday(): ?Carbon
    {
        return $this->birthday;
    }

    public function getCreatedAt(): Carbon
    {
        return $this->createdAt;
    }

}
