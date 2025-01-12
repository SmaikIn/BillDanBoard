<?php

namespace App\Dto;

use App\Domain\ValueObjects\Email;
use App\Domain\ValueObjects\Phone;
use App\Domain\ValueObjects\Photo;
use Carbon\Carbon;
use Ramsey\Uuid\UuidInterface;

final readonly class ProfileDto
{
    public function __construct(
        private UuidInterface $id,
        private UserDto $userDto,
        private CompanyDto $companyDto,
        private RoleDto $roleDto,
        private DepartmentDto $departmentDto,
        private string $firstName,
        private string $lastName,
        private ?string $secondName,
        private ?Phone $phone,
        private Photo $photo,
        private Email $email,
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

    public function getBirthday(): ?Carbon
    {
        return $this->birthday;
    }

    public function getCreatedAt(): Carbon
    {
        return $this->createdAt;
    }

    public function getUserDto(): UserDto
    {
        return $this->userDto;
    }

    public function getCompanyDto(): CompanyDto
    {
        return $this->companyDto;
    }

    public function getRoleDto(): RoleDto
    {
        return $this->roleDto;
    }

    public function getDepartmentDto(): DepartmentDto
    {
        return $this->departmentDto;
    }
}
