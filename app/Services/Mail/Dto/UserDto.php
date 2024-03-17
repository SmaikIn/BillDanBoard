<?php

declare(strict_types=1);

namespace App\Services\Mail\Dto;

use App\Domain\ValueObjects\Email;
use App\Domain\ValueObjects\Phone;
use App\Domain\ValueObjects\Photo;
use Carbon\Carbon;
use Ramsey\Uuid\UuidInterface;

final readonly class UserDto
{
    /**
     * @param  UuidInterface  $id
     * @param  string  $firstName
     * @param  string  $lastName
     * @param  string|null  $secondName
     * @param  Email  $email
     */
    public function __construct(
        private UuidInterface $id,
        private string $firstName,
        private string $lastName,
        private ?string $secondName,
        private Email $email,

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

    public function getEmail(): Email
    {
        return $this->email;
    }

}
