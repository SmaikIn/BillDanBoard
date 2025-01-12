<?php

namespace App\Services\Department\Repositories;

use App\Services\Department\Dto\CreateDepartmentDto;
use App\Services\Department\Dto\DepartmentDto;
use App\Services\Department\Dto\UpdateDepartmentDto;
use App\Services\Department\Repositories\DatabaseDepartmentRepository;
use App\Services\Department\Repositories\DepartmentRepository;
use Carbon\Carbon;
use Carbon\CarbonInterface;
use Illuminate\Cache\Repository;
use Ramsey\Uuid\UuidInterface;

final readonly class CacheDepartmentRepository implements DepartmentRepository
{

    const CACHE_TTL_DAYS = CarbonInterface::DAYS_PER_WEEK;

    public function __construct(
        private DatabaseDepartmentRepository $databaseDepartmentRepository,
        private Repository $cache,
        private \Illuminate\Config\Repository $config,
    ) {
    }

    public function getDepartmentsByCompanyId(UuidInterface $companyId): array
    {
        $key = $this->getKeyForCache($companyId->toString());

        return $this->cache->remember(
            $key,
            Carbon::parse(self::CACHE_TTL_DAYS.' days'),
            function () use ($companyId) {
                return $this->databaseDepartmentRepository->getDepartmentsByCompanyId($companyId);
            },
        );
    }

    public function getDepartmentByCompanyId(UuidInterface $companyId, UuidInterface $departmentId): ?DepartmentDto
    {
        $key = $this->getKeyForCache($companyId->toString());

        $Departments = $this->cache->remember(
            $key,
            Carbon::parse(self::CACHE_TTL_DAYS.' days'),
            function () use ($companyId) {
                return $this->databaseDepartmentRepository->getDepartmentsByCompanyId($companyId);
            },
        );

        /** @var DepartmentDto[] $Departments */
        foreach ($Departments as $Department) {
            if ($Department->getId()->toString() === $departmentId->toString()) {
                return $Department;
            }
        }

        return null;
    }


    public function createDepartmentByCompanyId(CreateDepartmentDto $DepartmentDto): DepartmentDto
    {
        $dbDepartmentDto = $this->databaseDepartmentRepository->createDepartmentByCompanyId($DepartmentDto);

        $this->forgetCache($dbDepartmentDto->getCompanyId());

        return $dbDepartmentDto;
    }

    public function updateDepartmentByCompanyId(UpdateDepartmentDto $DepartmentDto): DepartmentDto
    {
        $dbDepartmentDto = $this->databaseDepartmentRepository->updateDepartmentByCompanyId($DepartmentDto);

        $this->forgetCache($dbDepartmentDto->getCompanyId());

        return $dbDepartmentDto;
    }

    public function deleteDepartmentByCompanyId(UuidInterface $companyId, UuidInterface $departmentId): bool
    {
        $bool = $this->databaseDepartmentRepository->deleteDepartmentByCompanyId($companyId, $departmentId);

        $this->forgetCache($companyId);

        return $bool;
    }

    private function forgetCache(UuidInterface $companyId): void
    {
        $this->cache->forget($this->getKeyForCache($companyId->toString()));
    }

    private function getKeyForCache(string $companyId): string
    {
        return sprintf($this->config->get('cache.keys.department.company'), $companyId);
    }

}
