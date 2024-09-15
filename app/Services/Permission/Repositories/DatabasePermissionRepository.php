<?php

namespace App\Services\Permission\Repositories;

use App\Services\Permission\Dto\CreatePermissionDto;
use App\Services\Permission\Dto\UpdatePermissionDto;
final readonly class DatabasePermissionRepository implements PermissionRepository
{
    public function __construct(
    ){
    }

    public function find(int $id){
    //TODO logic
    }

    public function findMany(array $arrayIds){
    //TODO logic
    }

    public function delete(int $id){
    //TODO logic
    }

    public function create(CreatePermissionDto $dto){
    //TODO logic
    }

    public function update(UpdatePermissionDto $dto){
    //TODO logic
    }
}
