<?php

namespace App\Services\Department;

use App\Services\Department\Dto\CreateDepartmentDto;
use App\Services\Department\Dto\DepartmentDto;
use App\Services\Department\Dto\UpdateDepartmentDto;
use App\Services\Department\Repositories\DepartmentRepository;
use App\Services\Department\DepartmentService;
use Ramsey\Uuid\UuidInterface;

final readonly class LaravelDepartmentService implements DepartmentService
{
    public function __construct(
        private DepartmentRepository $repository,
    ) {
    }

    public function getDepartmentsByCompanyId(UuidInterface $companyId): array
    {
        return $this->repository->getDepartmentsByCompanyId($companyId);
    }

    public function getDepartmentByCompanyId(UuidInterface $companyId, UuidInterface $departmentId): DepartmentDto
    {
        return $this->repository->getDepartmentByCompanyId($companyId, $departmentId);
    }

    public function createDepartmentByCompanyId(CreateDepartmentDto $DepartmentDto): DepartmentDto
    {
        return $this->repository->createDepartmentByCompanyId($DepartmentDto);
    }

    public function updateDepartmentByCompanyId(UpdateDepartmentDto $DepartmentDto): DepartmentDto
    {
        return $this->repository->updateDepartmentByCompanyId($DepartmentDto);
    }

    public function deleteDepartmentByCompanyId(UuidInterface $companyId, UuidInterface $departmentId): bool
    {
        return $this->repository->deleteDepartmentByCompanyId($companyId, $departmentId);
    }


}
