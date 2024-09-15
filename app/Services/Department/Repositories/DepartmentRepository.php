<?php

namespace App\Services\Department\Repositories;

use App\Services\Department\Dto\CreateDepartmentDto;
use App\Services\Department\Dto\DepartmentDto;
use App\Services\Department\Dto\UpdateDepartmentDto;
use Ramsey\Uuid\UuidInterface;

interface DepartmentRepository
{
    public function getDepartmentsByCompanyId(UuidInterface $companyId): array;

    public function getDepartmentByCompanyId(UuidInterface $companyId, UuidInterface $departmentId): ?DepartmentDto;

    public function createDepartmentByCompanyId(CreateDepartmentDto $DepartmentDto): DepartmentDto;

    public function updateDepartmentByCompanyId(UpdateDepartmentDto $DepartmentDto): DepartmentDto;

    public function deleteDepartmentByCompanyId(UuidInterface $companyId, UuidInterface $departmentId): bool;

}
