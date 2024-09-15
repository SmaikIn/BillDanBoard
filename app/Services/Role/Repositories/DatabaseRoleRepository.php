<?php

namespace App\Services\Role\Repositories;

use App\Models\Role;
use App\Services\Role\Dto\CreateRoleDto;
use App\Services\Role\Dto\RoleDto;
use App\Services\Role\Dto\UpdateRoleDto;
use Carbon\Carbon;
use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;

final readonly class DatabaseRoleRepository implements RoleRepository
{
    public function __construct()
    {
    }

    /**
     * @param  UuidInterface  $companyId
     * @return RoleDto[]
     */
    public function getRolesByCompanyId(UuidInterface $companyId): array
    {
        $dbRoles = Role::where('company_id', $companyId->toString())->orderBy('name')->get();

        $roles = [];
        foreach ($dbRoles as $role) {
            $roles[] = $this->formatToDto($role);
        }

        return $roles;
    }

    public function getRoleByCompanyId(UuidInterface $companyId, UuidInterface $roleId): RoleDto
    {
        $role = Role::where('company_id', $companyId->toString())->where('uuid', $roleId->toString())->firstOrFail();

        return $this->formatToDto($role);
    }


    public function createRoleByCompanyId(CreateRoleDto $roleDto): RoleDto
    {
        $role = new Role();
        $role->uuid = Uuid::uuid4()->toString();
        $role->company_uuid = $roleDto->getCompanyUuid()->toString();
        $role->name = $roleDto->getName();
        $role->created_at = Carbon::now();

        $role->save();

        return $this->formatToDto($role);
    }

    public function updateRoleByCompanyId(UpdateRoleDto $roleDto): RoleDto
    {
        $role = Role::where('company_id', $roleDto->getCompanyUuid()->toString())->where('uuid',
            $roleDto->getUuid()->toString())->firstOrFail();

        $role->name = $roleDto->getName();
        $role->save();

        return $this->formatToDto($role);
    }

    public function deleteRoleByCompanyId(UuidInterface $companyId, UuidInterface $roleId): bool
    {
        $role = Role::where('company_id', $companyId->toString())->where('uuid', $roleId->toString())->firstOrFail();

        return $role->delete();
    }

    public function formatToDto(Role $role): RoleDto
    {
        return new RoleDto(
            uuid: Uuid::fromString($role->uuid),
            companyUuid: Uuid::fromString($role->company_uuid),
            name: $role->name,
            createdAt: Carbon::create($role->created_at),
        );
    }
}
