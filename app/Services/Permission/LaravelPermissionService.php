<?php

namespace App\Services\Permission;

use App\Services\Permission\Repositories\PermissionRepository;
use App\Services\Permission\Dto\CreatePermissionDto;
use App\Services\Permission\Dto\UpdatePermissionDto;
final readonly class LaravelPermissionService implements PermissionService
{
    public function __construct(
      private PermissionRepository $repository,
    ){
    }

    public function find(int $id){
      return $this->repository->find($id);
    }

    public function findMany(array $arrayIds){
      return $this->repository->findMany($arrayIds);
    }

    public function delete(int $id){
      return $this->repository->delete($id);
    }

    public function create(CreatePermissionDto $dto){
      return $this->repository->create($dto);
    }

    public function update(UpdatePermissionDto $dto){
       return $this->repository->update($dto);
    }
}
