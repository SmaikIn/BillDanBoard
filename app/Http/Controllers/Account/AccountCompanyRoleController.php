<?php

namespace App\Http\Controllers\Account;

use App\Dto\PermissionDto as PermissionFrontend;
use App\Dto\RoleDto as RoleFrontend;
use App\Http\Controllers\Controller;
use App\Http\Requests\CompanyRole\CreateCompanyRoleRequest;
use App\Http\Requests\CompanyRole\DeleteCompanyRoleRequest;
use App\Http\Requests\CompanyRole\GetCompanyRolePermissionRequest;
use App\Http\Requests\CompanyRole\IndexCompanyRoleRequest;
use App\Http\Requests\CompanyRole\ShowCompanyRoleRequest;
use App\Http\Requests\CompanyRole\UpdateCompanyRoleRequest;
use App\Http\Resources\PermissionResource;
use App\Http\Resources\RoleResource;
use App\Http\Responses\JsonApiResponse;
use App\Http\Responses\JsonErrorResponse;
use App\Services\Permission\Dto\PermissionDto;
use App\Services\Permission\PermissionService;
use App\Services\Role\Dto\CreateRoleDto;
use App\Services\Role\Dto\RoleDto;
use App\Services\Role\Dto\UpdateRoleDto;
use App\Services\Role\RoleService;
use App\Services\User\UserService;
use Illuminate\Support\Facades\Auth;
use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;
use Symfony\Component\HttpFoundation\Response;

class AccountCompanyRoleController extends Controller
{
    public function __construct(
        private readonly UserService $userService,
        private readonly RoleService $roleService,
        private readonly PermissionService $permissionService,
    ) {
    }

    public function index(IndexCompanyRoleRequest $request)
    {
        $companyId = $this->checkUserCompany($request->input('companyId'));

        if (is_null($companyId)) {
            return new JsonErrorResponse(__('errors.company.not exists'), status: Response::HTTP_FORBIDDEN);
        }

        $dbRoles = $this->roleService->getRolesByCompanyId($companyId);

        $roles = [];
        foreach ($dbRoles as $role) {
            $roles[] = $this->formatRoleDtoToFrontend($role);
        }


        return new JsonApiResponse(RoleResource::collection($roles)->toArray($request), status: Response::HTTP_OK);
    }

    public function store(CreateCompanyRoleRequest $request)
    {
        $companyId = $this->checkUserCompany($request->input('companyId'));
        if (is_null($companyId)) {
            return new JsonErrorResponse(__('errors.company.not exists'), status: Response::HTTP_FORBIDDEN);
        }

        $dto = new CreateRoleDto(
            $companyId,
            $request->input('roleName')
        );

        $role = $this->roleService->createRoleByCompanyId($dto);

        return new JsonApiResponse(RoleResource::make($this->formatRoleDtoToFrontend($role))->toArray($request),
            status: Response::HTTP_CREATED);
    }

    public function show(ShowCompanyRoleRequest $request)
    {
        $companyId = $this->checkUserCompany($request->input('companyId'));
        if (is_null($companyId)) {
            return new JsonErrorResponse(__('errors.company.not exists'), status: Response::HTTP_FORBIDDEN);
        }

        $roleId = Uuid::fromString($request->input('roleId'));
        $role = $this->roleService->getRoleByCompanyId($companyId, $roleId);

        return new JsonApiResponse(RoleResource::make($this->formatRoleDtoToFrontend($role))->toArray($request),
            status: Response::HTTP_OK);
    }

    public function update(UpdateCompanyRoleRequest $request)
    {
        $companyId = $this->checkUserCompany($request->input('companyId'));
        if (is_null($companyId)) {
            return new JsonErrorResponse(__('errors.company.not exists'), status: Response::HTTP_FORBIDDEN);
        }

        $dto = new UpdateRoleDto(
            Uuid::fromString($request->input('roleId')),
            Uuid::fromString($request->input('companyId')),
            $request->input('roleName'),
        );

        $role = $this->roleService->updateRoleByCompanyId($dto);

        return new JsonApiResponse(RoleResource::make($this->formatRoleDtoToFrontend($role))->toArray($request),
            status: Response::HTTP_OK);
    }

    public function destroy(DeleteCompanyRoleRequest $request)
    {
        $companyId = $this->checkUserCompany($request->input('companyId'));
        if (is_null($companyId)) {
            return new JsonErrorResponse(__('errors.company.not exists'), status: Response::HTTP_FORBIDDEN);
        }

        $roleId = Uuid::fromString($request->input('roleId'));
        $this->roleService->deleteRoleByCompanyId($companyId, $roleId);

        return new JsonApiResponse([], status: Response::HTTP_OK);
    }

    public function getRolePermission(GetCompanyRolePermissionRequest $request)
    {
        $companyId = $this->checkUserCompany($request->input('companyId'));
        if (is_null($companyId)) {
            return new JsonErrorResponse(__('errors.company.not exists'), status: Response::HTTP_FORBIDDEN);
        }
        $roleId = Uuid::fromString($request->input('roleId'));

        $permissionIds = $this->roleService->getRolePermissions($companyId, $roleId);

        $dbPermissions = $this->permissionService->findMany($permissionIds);

        $permissions = [];
        foreach ($dbPermissions as $dbPermission) {
            $permissions[] = $this->formatPermissionDtoToFrontend($dbPermission);
        }

        return new JsonApiResponse(PermissionResource::collection($permissions)->toArray($request),
            status: Response::HTTP_OK);
    }

    private function formatPermissionDtoToFrontend(PermissionDto $permissionDto): PermissionFrontend
    {
        return new PermissionFrontend(
            uuid: $permissionDto->getUuid(),
            name: $permissionDto->getName(),
            slug: $permissionDto->getSlug(),
            description: $permissionDto->getDescription(),
        );
    }

    private function formatRoleDtoToFrontend(RoleDto $roleDto): RoleFrontend
    {
        return new RoleFrontend(
            uuid: $roleDto->getId(),
            companyUuid: $roleDto->getCompanyId(),
            name: $roleDto->getName(),
            createdAt: $roleDto->getCreatedAt(),
        );
    }

    private function checkUserCompany(string $companyId): ?UuidInterface
    {
        $userId = Uuid::fromString(Auth::id());

        $companyIds = $this->userService->getCompanyIds($userId);;

        $key = array_search($companyId, $companyIds, true);

        if ($key === false) {
            return null;
        }

        return Uuid::fromString($companyIds[$key]);
    }
}
