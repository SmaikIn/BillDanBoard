<?php

namespace App\Services\Role;

use App\Services\Role\Dto\CreateRoleDto;
use App\Services\Role\Dto\RoleDto;
use App\Services\Role\Dto\UpdateRoleDto;
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

    public function createRoleByCompanyId(CreateRoleDto $roleDto): RoleDto
    {
        return $this->repository->createRoleByCompanyId($roleDto);
    }

    public function updateRoleByCompanyId(UpdateRoleDto $roleDto): RoleDto
    {
        return $this->repository->updateRoleByCompanyId($roleDto);
    }

    public function deleteRoleByCompanyId(UuidInterface $companyId, UuidInterface $roleId): bool
    {
        return $this->repository->deleteRoleByCompanyId($companyId, $roleId);
    }

    public function getRolePermissions(UuidInterface $companyId, UuidInterface $roleId): array
    {
        return $this->repository->getRolePermissions($companyId, $roleId);
    }


}
