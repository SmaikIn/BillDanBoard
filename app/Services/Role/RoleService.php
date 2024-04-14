<?php

namespace App\Services\Role;

use App\Services\Role\Dto\RoleDto;
use Ramsey\Uuid\UuidInterface;

interface RoleService
{
    public function getRolesByCompanyId(UuidInterface $companyId): array;

    public function getRoleByCompanyId(UuidInterface $companyId, UuidInterface $roleId): RoleDto;

    public function deleteRoleByCompanyId(UuidInterface $companyId, UuidInterface $roleId): UuidInterface;
}
