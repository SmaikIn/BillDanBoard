<?php

namespace App\Services\Permission\Dto;

use Ramsey\Uuid\UuidInterface;

final readonly class PermissionDto
{
    public function __construct(
        private UuidInterface $uuid,
        private string $name,
        private string $slug,
        private string $description,
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

    public function getSlug(): string
    {
        return $this->slug;
    }

    public function getDescription(): string
    {
        return $this->description;
    }
}
