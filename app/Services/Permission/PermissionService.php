<?php

namespace App\Services\Permission;

use App\Services\Permission\Dto\CreatePermissionDto;
use App\Services\Permission\Dto\UpdatePermissionDto;
interface PermissionService
{
    public function findMany(array $arrayIds);

}
