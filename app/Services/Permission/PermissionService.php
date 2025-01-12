<?php

namespace App\Services\Permission;

use App\Services\Permission\Dto\CreatePermissionDto;
use App\Services\Permission\Dto\PermissionDto;
use App\Services\Permission\Dto\UpdatePermissionDto;
interface PermissionService
{
    /**
     * @param  array  $arrayIds
     * @return PermissionDto[]
     */
    public function findMany(array $arrayIds): array;

    /**
     * @return PermissionDto[]
     */
    public function all(): array;

}
