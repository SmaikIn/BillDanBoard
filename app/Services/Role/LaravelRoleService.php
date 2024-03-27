<?php

namespace App\Services\Role;

use App\Services\Role\Repositories\RoleRepository;
use App\Services\Role\Dto\CreateRoleDto;
use App\Services\Role\Dto\UpdateRoleDto;

final readonly class LaravelRoleService implements RoleService
{
    public function __construct(
        private RoleRepository $repository,
    ) {
    }

    public function find(int $id)
    {
        return $this->repository->find($id);
    }

    public function findMany(array $arrayIds)
    {
        return $this->repository->findMany($arrayIds);
    }

    public function delete(int $id)
    {
        return $this->repository->delete($id);
    }

    public function create(CreateRoleDto $dto)
    {
        return $this->repository->create($dto);
    }

    public function update(UpdateRoleDto $dto)
    {
        return $this->repository->update($dto);
    }
}
