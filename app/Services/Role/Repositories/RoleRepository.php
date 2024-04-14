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
}
