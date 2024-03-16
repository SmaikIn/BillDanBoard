<?php

declare(strict_types=1);

namespace App\Services\User\Dto;

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
        private Phone $phone,
        private Photo $photo,
        private Email $email,
        private string $position,
        private string $description,
        private UuidInterface $companyId,
        private UuidInterface $departmentId,
        private UuidInterface $roleId,
        private ?string $yandexId,
        private Carbon $birthday,
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

    public function getPhone(): Phone
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

    public function getPosition(): string
    {
        return $this->position;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    public function getCompanyId(): UuidInterface
    {
        return $this->companyId;
    }

    public function getRoleId(): UuidInterface
    {
        return $this->roleId;
    }

    public function getDepartmentId(): UuidInterface
    {
        return $this->departmentId;
    }

    public function getYandexId(): ?string
    {
        return $this->yandexId;
    }

    public function getBirthday(): Carbon
    {
        return $this->birthday;
    }

    public function getCreatedAt(): Carbon
    {
        return $this->createdAt;
    }

}
