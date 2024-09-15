<?php

namespace App\Services\Permission\Repositories;

use App\Services\Permission\Dto\CreatePermissionDto;
use App\Services\Permission\Dto\UpdatePermissionDto;
interface PermissionRepository
{
    public function find(int $id);

    public function findMany(array $arrayIds);

    public function delete(int $id);

    public function create(CreatePermissionDto $dto);

    public function update(UpdatePermissionDto $dto);
}
