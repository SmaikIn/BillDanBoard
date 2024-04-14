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

    public function find(int $id)
    {
        //TODO logic
    }

    public function findMany(array $arrayIds)
    {
        //TODO logic
    }

    public function delete(int $id)
    {
        //TODO logic
    }

    public function create(CreateRoleDto $dto)
    {
        //TODO logic
    }

    public function update(UpdateRoleDto $dto)
    {
        //TODO logic
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
