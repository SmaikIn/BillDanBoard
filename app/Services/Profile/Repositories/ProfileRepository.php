<?php

namespace App\Services\Profile\Repositories;

use App\Services\Profile\Dto\CreateProfileDto;
use App\Services\Profile\Dto\ProfileDto;
use App\Services\Profile\Dto\UpdateProfileDto;
use Ramsey\Uuid\UuidInterface;

interface ProfileRepository
{
    public function getProfilesByCompanyId(UuidInterface $companyId): array;

    public function getProfileByCompanyId(UuidInterface $companyId, UuidInterface $profileId): ?ProfileDto;

    public function createProfileByCompanyId(CreateProfileDto $profileDto): ProfileDto;

    public function updateProfileByCompanyId(UpdateProfileDto $profileDto): ProfileDto;

    public function deleteProfileByCompanyId(UuidInterface $companyId, UuidInterface $profileId): bool;

    public function banProfile(UuidInterface $companyId, UuidInterface $profileId);

}
