<?php

namespace App\Services\Profile;

use App\Services\Profile\Dto\CreateProfileDto;
use App\Services\Profile\Dto\ProfileDto;
use App\Services\Profile\Dto\UpdateProfileDto;
use App\Services\Profile\Repositories\ProfileRepository;
use Ramsey\Uuid\UuidInterface;

final readonly class LaravelProfileService implements ProfileService
{
    public function __construct(
        private ProfileRepository $repository,
    ) {
    }

    /**
     * @param  UuidInterface  $companyId
     * @return ProfileDto[]
     */
    public function getProfilesByCompanyId(UuidInterface $companyId): array
    {
        return $this->repository->getProfilesByCompanyId($companyId);
    }

    public function getProfileByCompanyId(UuidInterface $companyId, UuidInterface $profileId): ProfileDto
    {
        return $this->repository->getProfileByCompanyId($companyId, $profileId);
    }

    public function createProfileByCompanyId(CreateProfileDto $profileDto): ProfileDto
    {
        return $this->repository->createProfileByCompanyId($profileDto);
    }

    public function updateProfileByCompanyId(UpdateProfileDto $profileDto): ProfileDto
    {
        return $this->repository->updateProfileByCompanyId($profileDto);
    }

    public function deleteProfileByCompanyId(UuidInterface $companyId, UuidInterface $profileId): bool
    {
        $bool = $this->repository->deleteProfileByCompanyId($companyId, $profileId);



        return $bool;
    }


    public function inviteUserToCompany()
    {
    }

    public function banUser()
    {
    }


}
