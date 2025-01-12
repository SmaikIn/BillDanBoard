<?php

namespace App\Services\Profile\Dto;

use App\Domain\ValueObjects\Email;
use App\Domain\ValueObjects\Phone;
use App\Domain\ValueObjects\Photo;
use Carbon\Carbon;
use Ramsey\Uuid\UuidInterface;

final readonly class CreateProfileDto
{
    public function __construct(
        private UuidInterface $userId,
        private UuidInterface $companyId,
        private UuidInterface $roleId,
        private UuidInterface $departmentId,
        private string $firstName,
        private string $lastName,
        private ?string $secondName,
        private ?Phone $phone,
        private Photo $photo,
        private Email $email,
        private ?Carbon $birthday,
    ) {
    }

    public function getUserId(): UuidInterface
    {
        return $this->userId;
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

    public function getBirthday(): ?Carbon
    {
        return $this->birthday;
    }

}
