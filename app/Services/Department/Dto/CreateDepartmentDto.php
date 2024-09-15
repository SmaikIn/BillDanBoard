<?php

namespace App\Services\Department\Dto;

use Ramsey\Uuid\UuidInterface;

final readonly class CreateDepartmentDto
{
    public function __construct(
        private UuidInterface $companyUuid,
        private string $name,
    ) {
    }

    public function getCompanyUuid(): UuidInterface
    {
        return $this->companyUuid;
    }

    public function getName(): string
    {
        return $this->name;
    }

}
