<?php

namespace App\Services\Role\Repositories;

use App\Services\Role\Dto\CreateRoleDto;
use App\Services\Role\Dto\UpdateRoleDto;

interface RoleRepository
{
    public function find(int $id);

    public function findMany(array $arrayIds);

    public function delete(int $id);

    public function create(CreateRoleDto $dto);

    public function update(UpdateRoleDto $dto);
}
