<?php

namespace App\Http\Formater;

use App\Dto\CompanyDto as CompanyFrontend;
use App\Dto\DepartmentDto as DepartmentFrontend;
use App\Dto\PaginationDto;
use App\Dto\PermissionDto as PermissionFrontend;
use App\Dto\ProfileDto as ProfileFrontend;
use App\Dto\RoleDto as RoleFrontend;
use App\Dto\UserDto as UserFrontend;
use App\Enum\Resource;
use App\Http\Resources\CompanyResource;
use App\Http\Resources\DepartmentResource;
use App\Http\Resources\PaginateResource;
use App\Http\Resources\ProfileResource;
use App\Http\Resources\RoleResource;
use App\Http\Resources\User\UserResource;
use App\Services\Company\CompanyService;
use App\Services\Company\Dto\CompanyDto;
use App\Services\Department\DepartmentService;
use App\Services\Department\Dto\DepartmentDto;
use App\Services\Permission\Dto\PermissionDto;
use App\Services\Profile\Dto\ProfileDto;
use App\Services\Role\Dto\RoleDto;
use App\Services\Role\RoleService;
use App\Services\User\Dto\UserDto;
use App\Services\User\UserService;
use Illuminate\Pagination\LengthAwarePaginator;

final readonly class Formater
{

    public function __construct(
        private UserService $userService,
        private CompanyService $companyService,
        private RoleService $roleService,
        private DepartmentService $departmentService,
    ) {
    }

    private const ITEMS_ON_PAGE = 16;

    public function formatPagination(array $items, Resource $resource, int $page = 1,): PaginateResource
    {
        $total = count($items);
        $paginator = new LengthAwarePaginator($items, $total, self::ITEMS_ON_PAGE);

        $array = $paginator->forPage($page, $paginator->perPage())->toArray();

        $collection = match ($resource) {
            Resource::Company => CompanyResource::collection($array),
            Resource::Department => DepartmentResource::collection($array),
            Resource::Role => RoleResource::collection($array),
            Resource::User => UserResource::collection($array),
            Resource::Profile => ProfileResource::collection($array),
        };

        $dto = new PaginationDto(
            $collection,
            $resource,
            $total,
            $paginator->currentPage(),
            $paginator->perPage(),
        );

        return PaginateResource::make($dto);
    }

    public function formatCompanyDtoToFrontend(CompanyDto $companyDto): CompanyFrontend
    {
        return new CompanyFrontend(
            uuid: $companyDto->getUuid(),
            name: $companyDto->getName(),
            inn: $companyDto->getInn(),
            kpp: $companyDto->getKpp(),
            email: $companyDto->getEmail(),
            phone: $companyDto->getPhone(),
            url: $companyDto->getUrl(),
            description: $companyDto->getDescription(),
            isActive: $companyDto->isActive(),
        );
    }

    public function formatDepartmentDtoToFrontend(DepartmentDto $departmentDto): DepartmentFrontend
    {
        return new DepartmentFrontend(
            uuid: $departmentDto->getId(),
            companyUuid: $departmentDto->getCompanyId(),
            name: $departmentDto->getName(),
            createdAt: $departmentDto->getCreatedAt(),
        );
    }

    public function formatUserDtoToFrontend(UserDto $userDto): UserFrontend
    {
        return new UserFrontend(
            id: $userDto->getId(),
            firstName: $userDto->getFirstName(),
            lastName: $userDto->getLastName(),
            secondName: $userDto->getSecondName(),
            phone: $userDto->getPhone(),
            photo: $userDto->getPhoto(),
            email: $userDto->getEmail(),
            yandexId: $userDto->getYandexId(),
            birthday: $userDto->getBirthday(),
            createdAt: $userDto->getCreatedAt(),
        );
    }

    public function formatRoleDtoToFrontend(RoleDto $roleDto): RoleFrontend
    {
        return new RoleFrontend(
            uuid: $roleDto->getId(),
            companyUuid: $roleDto->getCompanyId(),
            name: $roleDto->getName(),
            createdAt: $roleDto->getCreatedAt(),
        );
    }

    public function formatPermissionDtoToFrontend(PermissionDto $permissionDto): PermissionFrontend
    {
        return new PermissionFrontend(
            uuid: $permissionDto->getUuid(),
            name: $permissionDto->getName(),
            slug: $permissionDto->getSlug(),
            description: $permissionDto->getDescription(),
        );
    }

    public function formatProfileDtoToFrontend(ProfileDto $dbProfile): ProfileFrontend
    {
        $userDto = $this->userService->find($dbProfile->getUserId());
        $companyDto = $this->companyService->find($dbProfile->getCompanyId());
        $roleDto = $this->roleService->getRoleByCompanyId($dbProfile->getCompanyId(), $dbProfile->getRoleId());
        $departmentDto = $this->departmentService->getDepartmentByCompanyId($dbProfile->getCompanyId(),
            $dbProfile->getDepartmentId());

        return new ProfileFrontend(
            id: $dbProfile->getId(),
            userDto: $this->formatUserDtoToFrontend($userDto),
            companyDto: $this->formatCompanyDtoToFrontend($companyDto),
            roleDto: $this->formatRoleDtoToFrontend($roleDto),
            departmentDto: $this->formatDepartmentDtoToFrontend($departmentDto),
            firstName: $dbProfile->getFirstName(),
            lastName: $dbProfile->getLastName(),
            secondName: $dbProfile->getSecondName(),
            phone: $dbProfile->getPhone(),
            photo: $dbProfile->getPhoto(),
            email: $dbProfile->getEmail(),
            birthday: $dbProfile->getBirthday(),
            createdAt: $dbProfile->getCreatedAt(),
        );
    }
}