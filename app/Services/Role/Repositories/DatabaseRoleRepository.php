<?php

namespace App\Services\Role\Repositories;

use App\Services\Role\Dto\CreateRoleDto;
use App\Services\Role\Dto\UpdateRoleDto;

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
}
