<?php

namespace App\Services\Role\Repositories;

use App\Services\Role\Dto\RoleDto;
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
            function ($companyId) {
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
            function ($companyId) {
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

    private function getKeyForCache(string $companyId): string
    {
        return $this->config->get('cache.keys.role.company').'-'.$companyId;
    }
}
