<?php

namespace App\Services\Profile\Repositories;

use App\Services\Profile\Dto\CreateProfileDto;
use App\Services\Profile\Dto\ProfileDto;
use App\Services\Profile\Dto\UpdateProfileDto;
use Carbon\Carbon;
use Carbon\CarbonInterface;
use Illuminate\Cache\Repository;
use Ramsey\Uuid\UuidInterface;

final readonly class CacheProfileRepository implements ProfileRepository
{

    const CACHE_TTL_DAYS = CarbonInterface::DAYS_PER_WEEK;

    public function __construct(
        private DatabaseProfileRepository $databaseProfileRepository,
        private Repository $cache,
        private \Illuminate\Config\Repository $config,
    ) {
    }

    public function getProfilesByCompanyId(UuidInterface $companyId): array
    {
        $key = $this->getKeyForCache($companyId->toString());

        return $this->cache->remember(
            $key,
            Carbon::parse(self::CACHE_TTL_DAYS.' days'),
            function () use ($companyId) {
                return $this->databaseProfileRepository->getProfilesByCompanyId($companyId);
            },
        );
    }

    public function getProfileByCompanyId(UuidInterface $companyId, UuidInterface $profileId): ?ProfileDto
    {
        $key = $this->getKeyForCache($companyId->toString());

        $profiles = $this->cache->remember(
            $key,
            Carbon::parse(self::CACHE_TTL_DAYS.' days'),
            function () use ($companyId) {
                return $this->databaseProfileRepository->getProfilesByCompanyId($companyId);
            },
        );

        /** @var ProfileDto[] $profiles */
        foreach ($profiles as $profile) {
            if ($profile->getId()->toString() === $profileId->toString()) {
                return $profile;
            }
        }

        return null;
    }


    public function createProfileByCompanyId(CreateProfileDto $profileDto): ProfileDto
    {
        $dbProfileDto = $this->databaseProfileRepository->createProfileByCompanyId($profileDto);

        $this->forgetCache($dbProfileDto->getCompanyId());

        return $dbProfileDto;
    }

    public function updateProfileByCompanyId(UpdateProfileDto $profileDto): ProfileDto
    {
        $dbProfileDto = $this->databaseProfileRepository->updateProfileByCompanyId($profileDto);

        $this->forgetCache($dbProfileDto->getCompanyId());

        return $dbProfileDto;
    }

    public function deleteProfileByCompanyId(UuidInterface $companyId, UuidInterface $profileId): bool
    {
        $bool = $this->databaseProfileRepository->deleteProfileByCompanyId($companyId, $profileId);

        $this->forgetCache($companyId);

        return $bool;
    }

    public function banUser()
    {
    }

    private function forgetCache(UuidInterface $companyId): void
    {
        $this->cache->forget($this->getKeyForCache($companyId->toString()));
    }

    private function getKeyForCache(string $companyId): string
    {
        return $this->config->get('cache.keys.profile.company').'-'.$companyId;
    }

}
