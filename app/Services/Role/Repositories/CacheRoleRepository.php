<?php

namespace App\Services\Role\Repositories;

use App\Services\Role\Dto\CreateRoleDto;
use App\Services\Role\Dto\RoleDto;
use App\Services\Role\Dto\UpdateRoleDto;
use Carbon\Carbon;
use Carbon\CarbonInterface;
use Illuminate\Cache\Repository;
use Ramsey\Uuid\UuidInterface;

final readonly class CacheRoleRepository implements RoleRepository
{

    const CACHE_TTL_DAYS = CarbonInterface::DAYS_PER_WEEK;

    public function __construct(
        private DatabaseRoleRepository $databaseRoleRepository,
        private Repository $cache,
        private \Illuminate\Config\Repository $config,
    ) {
    }

    public function getRolesByCompanyId(UuidInterface $companyId): array
    {
        $key = $this->getKeyForCache($companyId->toString());

        return $this->cache->remember(
            $key,
            Carbon::parse(self::CACHE_TTL_DAYS.' days'),
            function () use ($companyId) {
                return $this->databaseRoleRepository->getRolesByCompanyId($companyId);
            },
        );
    }

    public function getRoleByCompanyId(UuidInterface $companyId, UuidInterface $roleId): ?RoleDto
    {
        $key = $this->getKeyForCache($companyId->toString());

        $roles = $this->cache->remember(
            $key,
            Carbon::parse(self::CACHE_TTL_DAYS.' days'),
            function () use ($companyId) {
                return $this->databaseRoleRepository->getRolesByCompanyId($companyId);
            },
        );

        /** @var RoleDto[] $roles */
        foreach ($roles as $role) {
            if ($role->getId()->toString() === $roleId->toString()) {
                return $role;
            }
        }

        return null;
    }


    public function createRoleByCompanyId(CreateRoleDto $roleDto): RoleDto
    {
        $dbRoleDto = $this->databaseRoleRepository->createRoleByCompanyId($roleDto);

        $this->forgetCache($dbRoleDto->getCompanyId());

        return $dbRoleDto;
    }

    public function updateRoleByCompanyId(UpdateRoleDto $roleDto): RoleDto
    {
        $dbRoleDto = $this->databaseRoleRepository->updateRoleByCompanyId($roleDto);

        $this->forgetCache($dbRoleDto->getCompanyId());

        return $dbRoleDto;
    }

    public function deleteRoleByCompanyId(UuidInterface $companyId, UuidInterface $roleId): bool
    {
        $bool = $this->databaseRoleRepository->deleteRoleByCompanyId($companyId, $roleId);

        $this->forgetCache($companyId);

        return $bool;
    }

    /**
     * @param  UuidInterface  $companyId
     * @param  UuidInterface  $roleId
     * @return UuidInterface[]
     */
    public function getRolePermissions(UuidInterface $companyId, UuidInterface $roleId): array
    {
        $key = sprintf($this->config->get('cache.keys.role.permissions'), $companyId->toString().$roleId->toString());

        return $this->cache->remember(
            $key,
            Carbon::parse(self::CACHE_TTL_DAYS.' days'),
            function () use ($companyId, $roleId) {
                return;
            },
        );
    }


    public function appendPermissionsToRole(UuidInterface $roleId, array $permissionIds): void
    {
        $this->databaseRoleRepository->appendPermissionsToRole($roleId, $permissionIds);
    }

    private function forgetCache(UuidInterface $companyId): void
    {
        $this->cache->forget($this->getKeyForCache($companyId->toString()));
    }

    private function getKeyForCache(string $companyId): string
    {
        return sprintf($this->config->get('cache.keys.role.company'), $companyId);
    }

}
