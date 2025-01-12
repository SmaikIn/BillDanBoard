<?php

namespace App\Services\Permission;

use App\Services\Permission\Dto\PermissionDto;
use App\Services\Permission\Repositories\PermissionRepository;

final readonly class LaravelPermissionService implements PermissionService
{
    public function __construct(
        private PermissionRepository $repository,
    ) {
    }

    /**
     * @param  array  $arrayIds
     * @return PermissionDto[]
     */
    public function findMany(array $arrayIds): array
    {
        return $this->repository->findMany($arrayIds);
    }
}
