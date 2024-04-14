<?php

namespace App\Services\Role;

use App\Services\Role\Dto\RoleDto;
use App\Services\Role\Repositories\RoleRepository;
use Ramsey\Uuid\UuidInterface;

final readonly class LaravelRoleService implements RoleService
{
    public function __construct(
        private RoleRepository $repository,
    ) {
    }

    public function getRolesByCompanyId(UuidInterface $companyId): array
    {
        return $this->repository->getRolesByCompanyId($companyId);
    }

    public function getRoleByCompanyId(UuidInterface $companyId, UuidInterface $roleId): RoleDto
    {
        return $this->repository->getRoleByCompanyId($companyId, $roleId);
    }
}
