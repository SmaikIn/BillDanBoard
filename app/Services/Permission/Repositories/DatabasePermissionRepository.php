<?php

namespace App\Services\Permission\Repositories;

use App\Models\Permission;
use App\Services\Permission\Dto\PermissionDto;
use Ramsey\Uuid\Uuid;

final readonly class DatabasePermissionRepository implements PermissionRepository
{
    public function __construct()
    {
    }


    /**
     * @param  string[]  $arrayIds
     * @return PermissionDto[]
     */
    public function findMany(array $arrayIds): array
    {
        $dbPermissions = Permission::whereIn('uuid', $arrayIds)->get();

        $permissions = [];
        foreach ($dbPermissions as $dbPermission) {
            $permissions[] = $this->formatToDto($dbPermission);
        }

        return $permissions;
    }

    private function formatToDto(Permission $permission): PermissionDto
    {
        return new PermissionDto(
            uuid: Uuid::fromString($permission->uuid),
            name: $permission->name,
            slug: $permission->slug,
            description: $permission->description,
        );
    }


}
