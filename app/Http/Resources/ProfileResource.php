<?php

namespace App\Http\Resources;

use App\Dto\ProfileDto;
use App\Http\Resources\User\UserResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProfileResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        /**
         * @var ProfileDto $this
         */

        $profile = $this;

        return [
            'id' => $profile->getId()->toString(),
            'firstName' => $profile->getFirstName(),
            'lastName' => $profile->getLastName(),
            'secondName' => $profile->getSecondName(),
            'phone' => $profile->getPhone()->value(),
            'photo' => $profile->getPhoto()->getUrl(),
            'email' => $profile->getEmail()->value(),
            'birthday' => $profile->getBirthday(),
            'createdAt' => $profile->getCreatedAt(),
            'user' => UserResource::make($profile->getUserDto()),
            'company' => CompanyResource::make($profile->getCompanyDto()),
            'role' => RoleResource::make($profile->getRoleDto()),
            'department' => DepartmentResource::make($profile->getDepartmentDto()),
        ];
    }
}
