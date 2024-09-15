<?php

namespace App\Services\Permission;

use App\Services\Permission\Dto\CreatePermissionDto;
use App\Services\Permission\Dto\UpdatePermissionDto;
interface PermissionService
{
    public function find(int $id);

    public function findMany(array $arrayIds);

    public function delete(int $id);

    public function create(CreatePermissionDto $dto);

    public function update(UpdatePermissionDto $dto);
}
