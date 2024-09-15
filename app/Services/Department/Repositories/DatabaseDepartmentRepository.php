<?php

namespace App\Services\Department\Repositories;

use App\Models\Department;
use App\Services\Department\Dto\CreateDepartmentDto;
use App\Services\Department\Dto\DepartmentDto;
use App\Services\Department\Dto\UpdateDepartmentDto;
use App\Services\Department\Repositories\DepartmentRepository;
use Carbon\Carbon;
use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;

final readonly class DatabaseDepartmentRepository implements DepartmentRepository
{
    public function __construct()
    {
    }

    /**
     * @param  UuidInterface  $companyId
     * @return DepartmentDto[]
     */
    public function getDepartmentsByCompanyId(UuidInterface $companyId): array
    {
        $dbDepartments = Department::where('company_uuid', $companyId->toString())->orderBy('name')->get();

        $Departments = [];
        foreach ($dbDepartments as $Department) {
            $Departments[] = $this->formatToDto($Department);
        }

        return $Departments;
    }

    public function getDepartmentByCompanyId(UuidInterface $companyId, UuidInterface $departmentId): DepartmentDto
    {
        $Department = Department::where('company_uuid', $companyId->toString())->where('uuid', $departmentId->toString())->firstOrFail();

        return $this->formatToDto($Department);
    }


    public function createDepartmentByCompanyId(CreateDepartmentDto $DepartmentDto): DepartmentDto
    {
        $Department = new Department();
        $Department->uuid = Uuid::uuid4()->toString();
        $Department->company_uuid = $DepartmentDto->getCompanyUuid()->toString();
        $Department->name = $DepartmentDto->getName();
        $Department->created_at = Carbon::now();

        $Department->save();

        return $this->formatToDto($Department);
    }

    public function updateDepartmentByCompanyId(UpdateDepartmentDto $DepartmentDto): DepartmentDto
    {
        $Department = Department::where('company_uuid', $DepartmentDto->getCompanyUuid()->toString())
            ->where('uuid', $DepartmentDto->getUuid()->toString())->firstOrFail();

        $Department->name = $DepartmentDto->getName();
        $Department->save();

        return $this->formatToDto($Department);
    }

    public function deleteDepartmentByCompanyId(UuidInterface $companyId, UuidInterface $departmentId): bool
    {
        $Department = Department::where('company_uuid', $companyId->toString())->where('uuid', $departmentId->toString())->firstOrFail();

        return $Department->delete();
    }

    public function formatToDto(Department $Department): DepartmentDto
    {
        return new DepartmentDto(
            uuid: Uuid::fromString($Department->uuid),
            companyUuid: Uuid::fromString($Department->company_uuid),
            name: $Department->name,
            createdAt: Carbon::create($Department->created_at),
        );
    }
}
