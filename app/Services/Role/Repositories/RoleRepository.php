<?php

namespace App\Services\Role\Repositories;

use App\Services\Role\Dto\CreateRoleDto;
use App\Services\Role\Dto\RoleDto;
use App\Services\Role\Dto\UpdateRoleDto;
use Ramsey\Uuid\UuidInterface;

interface RoleRepository
{
    public function getRolesByCompanyId(UuidInterface $companyId): array;

    public function getRoleByCompanyId(UuidInterface $companyId, UuidInterface $roleId): ?RoleDto;

    public function createRoleByCompanyId(CreateRoleDto $roleDto): RoleDto;

    public function updateRoleByCompanyId(UpdateRoleDto $roleDto): RoleDto;

    public function deleteRoleByCompanyId(UuidInterface $companyId, UuidInterface $roleId): bool;

    /**
     * @param  UuidInterface  $companyId
     * @param  UuidInterface  $roleId
     * @return UuidInterface[]
     */
    public function getRolePermissions(UuidInterface $companyId, UuidInterface $roleId): array;


}
