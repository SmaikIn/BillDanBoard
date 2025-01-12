<?php

namespace App\Services\Role;

use App\Services\Role\Dto\CreateRoleDto;
use App\Services\Role\Dto\RoleDto;
use App\Services\Role\Dto\UpdateRoleDto;
use Ramsey\Uuid\UuidInterface;

interface RoleService
{
    public function getRolesByCompanyId(UuidInterface $companyId): array;

    public function getRoleByCompanyId(UuidInterface $companyId, UuidInterface $roleId): RoleDto;

    public function createRoleByCompanyId(CreateRoleDto $roleDto): RoleDto;

    public function updateRoleByCompanyId(UpdateRoleDto $roleDto): RoleDto;

    public function deleteRoleByCompanyId(UuidInterface $companyId, UuidInterface $roleId): bool;

    /**
     * @param  UuidInterface  $companyId
     * @param  UuidInterface  $roleId
     * @return string[]
     */
    public function getRolePermissions(UuidInterface $companyId, UuidInterface $roleId): array;

    public function appendPermissionsToRole(UuidInterface $roleId, array $permissionIds): void;
}
