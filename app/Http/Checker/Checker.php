<?php

namespace App\Http\Checker;

use App\Dto\CompanyDto as CompanyFrontend;
use App\Dto\DepartmentDto as DepartmentFrontend;
use App\Dto\PaginationDto;
use App\Dto\RoleDto as RoleFrontend;
use App\Dto\UserDto as UserFrontend;
use App\Enum\Resource;
use App\Http\Resources\CompanyResource;
use App\Http\Resources\PaginateResource;
use App\Services\Company\Dto\CompanyDto;
use App\Services\Department\Dto\DepartmentDto;
use App\Services\Role\Dto\RoleDto;
use App\Services\User\Dto\UserDto;
use App\Services\User\UserService;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Auth;
use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;

final readonly class Checker
{
    public function __construct(
        private UserService $userService,
    ){
    }

    public function checkUserCompany(UuidInterface $id): bool
    {
        $userId = Uuid::fromString(Auth::id());

        $companiesIds = $this->userService->getCompanyIds($userId);

        $exists = false;
        foreach ($companiesIds as $companiesId) {
            if ($companiesId == $id->toString()) {
                $exists = true;
                break;
            }
        }

        return $exists;
    }
}