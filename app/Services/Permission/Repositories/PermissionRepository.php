<?php

namespace App\Services\Permission\Repositories;

interface PermissionRepository
{
    public function findMany(array $arrayIds);
}
