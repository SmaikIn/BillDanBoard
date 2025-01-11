<?php

namespace App\Dto;

use Carbon\Carbon;
use Ramsey\Uuid\UuidInterface;

final readonly class RoleDto
{
    public function __construct(
        private UuidInterface $uuid,
        private UuidInterface $companyUuid,
        private string $name,
        private Carbon $createdAt,
    ) {
    }

    public function getId(): UuidInterface
    {
        return $this->uuid;
    }

    public function getCompanyId(): UuidInterface
    {
        return $this->companyUuid;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getCreatedAt(): Carbon
    {
        return $this->createdAt;
    }
}
