<?php

namespace App\Services\Company\Dto;

use App\Domain\ValueObjects\Email;
use App\Domain\ValueObjects\Inn;
use App\Domain\ValueObjects\Kpp;
use App\Domain\ValueObjects\Phone;
use Ramsey\Uuid\UuidInterface;

final readonly class CompanyDto
{
    /**
     * @param  UuidInterface  $uuid
     * @param  string  $name
     * @param  Inn  $inn
     * @param  Kpp  $kpp
     * @param  Email  $email
     * @param  Phone  $phone
     * @param  string  $url
     * @param  string  $description
     * @param  bool  $isActive
     */
    public function __construct(
        private UuidInterface $uuid,
        private string $name,
        private Inn $inn,
        private ?Kpp $kpp,
        private Email $email,
        private Phone $phone,
        private ?string $url,
        private ?string $description,
        private bool $isActive,
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
