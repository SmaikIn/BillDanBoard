<?php

namespace App\Services\Company\Dto;

use App\Domain\ValueObjects\Email;
use App\Domain\ValueObjects\Inn;
use App\Domain\ValueObjects\Kpp;
use App\Domain\ValueObjects\Phone;
use Ramsey\Uuid\UuidInterface;

final readonly class CreateCompanyDto
{
    /**
     * @param  string  $name
     * @param  Inn  $inn
     * @param  Kpp|null  $kpp
     * @param  Email  $email
     * @param  Phone  $phone
     * @param  string|null  $url
     * @param  string|null  $description
     */
    public function __construct(
        private string $name,
        private Inn $inn,
        private ?Kpp $kpp,
        private Email $email,
        private Phone $phone,
        private ?string $url,
        private ?string $description,
    ) {
    }

    public function getUuid(): UuidInterface
    {
        return $this->uuid;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getInn(): Inn
    {
        return $this->inn;
    }

    public function getKpp(): ?Kpp
    {
        return $this->kpp;
    }

    public function getEmail(): Email
    {
        return $this->email;
    }

    public function getPhone(): Phone
    {
        return $this->phone;
    }

    public function getUrl(): ?string
    {
        return $this->url;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function isActive(): bool
    {
        return $this->isActive;
    }
}
