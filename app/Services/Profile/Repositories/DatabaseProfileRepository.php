<?php

namespace App\Services\Profile\Repositories;

use App\Domain\ValueObjects\Email;
use App\Domain\ValueObjects\Phone;
use App\Domain\ValueObjects\Photo;
use App\Models\Profile;
use App\Services\Profile\Dto\CreateProfileDto;
use App\Services\Profile\Dto\ProfileDto;
use App\Services\Profile\Dto\UpdateProfileDto;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;

final readonly class DatabaseProfileRepository implements ProfileRepository
{
    public function __construct()
    {
    }

    /**
     * @param  UuidInterface  $companyId
     * @return ProfileDto[]
     */
    public function getProfilesByCompanyId(UuidInterface $companyId): array
    {
        $dbProfiles = Profile::where('company_uuid', $companyId->toString())->get();

        $profiles = [];
        foreach ($dbProfiles as $profile) {
            $profiles[] = $this->formatToDto($profile);
        }

        return $profiles;
    }

    public function getProfileByCompanyId(UuidInterface $companyId, UuidInterface $profileId): ProfileDto
    {
        $profile = Profile::where('company_uuid', $companyId->toString())->where('uuid',
            $profileId->toString())->firstOrFail();

        return $this->formatToDto($profile);
    }

    public function updateProfileByCompanyId(UpdateProfileDto $profileDto): ProfileDto
    {
        $profile = Profile::where('company_uuid', $profileDto->getCompanyUuid()->toString())
            ->where('uuid', $profileDto->getUuid()->toString())->firstOrFail();

        $profile->name = $profileDto->getName();
        $profile->save();

        return $this->formatToDto($profile);
    }

    public function deleteProfileByCompanyId(UuidInterface $companyId, UuidInterface $profileId): bool
    {
        $profile = Profile::where('company_uuid', $companyId->toString())->where('uuid',
            $profileId->toString())->firstOrFail();

        return $profile->delete();
    }

    public function banProfile(UuidInterface $companyId, UuidInterface $profileId): bool
    {
        try {
            $profile = Profile::where('company_uuid', $companyId->toString())
                ->where('uuid', $profileId->toString())->firstOrFail();
        } catch (ModelNotFoundException $exception) {
            return false;
        }

        $profile->is_active = 0;
        $profile->save();

        return true;
    }

    public function createProfileByCompanyId(CreateProfileDto $profileDto): ProfileDto
    {
        $profile = new Profile();

        $profile->company_uuid = $profileDto->getCompanyId()->toString();
        $profile->department_uuid = $profileDto->getDepartmentId()->toString();
        $profile->role_uuid = $profileDto->getRoleId()->toString();
        $profile->user_uuid = $profileDto->getUserId()->toString();
        $profile->first_name = $profileDto->getFirstName();
        $profile->second_name = $profileDto->getSecondName();
        $profile->email = $profileDto->getEmail();
        $profile->phone = $profileDto->getPhone();
        $profile->avatar = $profileDto->getPhoto();
        $profile->birthday = $profileDto->getBirthday();
        $profile->is_active = 1;
        $profile->created_at = Carbon::now();
        $profile->save();

        return $this->formatToDto($profile);
    }

    public function formatToDto(Profile $profile): ProfileDto
    {
        return new ProfileDto(
            id: Uuid::fromString($profile->uuid),
            userId: Uuid::fromString($profile->user_uuid),
            companyId: Uuid::fromString($profile->company_uuid),
            roleId: Uuid::fromString($profile->role_uuid),
            departmentId: Uuid::fromString($profile->department_uuid),
            firstName: $profile->first_name,
            lastName: $profile->last_name,
            secondName: $profile->second_name,
            phone: Phone::create($profile->phone),
            photo: Photo::create(
                asset($profile->avatar),
                'Фото: '.$profile->first_name.' '.$profile->last_name,
            ),
            email: Email::create($profile->email),
            birthday: Carbon::create($profile->birthday),
            createdAt: Carbon::create($profile->created_at),
        );
    }


}
