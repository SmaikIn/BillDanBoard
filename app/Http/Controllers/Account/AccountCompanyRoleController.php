<?php

namespace App\Http\Controllers\Account;

use App\Enum\Resource;
use App\Http\Controllers\Controller;
use App\Http\Formater\Formater;
use App\Http\Requests\CompanyRole\CreateCompanyRoleRequest;
use App\Http\Requests\CompanyRole\DeleteCompanyRoleRequest;
use App\Http\Requests\CompanyRole\GetCompanyRolePermissionRequest;
use App\Http\Requests\CompanyRole\IndexCompanyRoleRequest;
use App\Http\Requests\CompanyRole\ShowCompanyRoleRequest;
use App\Http\Requests\CompanyRole\UpdateCompanyRoleRequest;
use App\Http\Resources\PermissionResource;
use App\Http\Resources\RoleResource;
use App\Http\Responses\JsonApiResponse;
use App\Services\Permission\PermissionService;
use App\Services\Role\Dto\CreateRoleDto;
use App\Services\Role\Dto\UpdateRoleDto;
use App\Services\Role\RoleService;
use Ramsey\Uuid\Uuid;
use Symfony\Component\HttpFoundation\Response;

class AccountCompanyRoleController extends Controller
{
    public function __construct(
        private readonly RoleService $roleService,
        private readonly PermissionService $permissionService,
        private readonly Formater $formater
    ) {
    }

    public function index(IndexCompanyRoleRequest $request)
    {
        $companyId = Uuid::fromString($request->get('companyId'));

        $dbRoles = $this->roleService->getRolesByCompanyId($companyId);

        $roles = [];
        foreach ($dbRoles as $role) {
            $roles[] = $this->formater->formatRoleDtoToFrontend($role);
        }

        $pagination = $this->formater->formatPagination($roles, Resource::Role, $request->get('page', 1));

        return new JsonApiResponse(RoleResource::collection($roles)->toArray($request), status: Response::HTTP_OK);
    }

    public function store(CreateCompanyRoleRequest $request)
    {
        $companyId = Uuid::fromString($request->get('companyId'));

        $dto = new CreateRoleDto(
            $companyId,
            $request->input('roleName')
        );

        $role = $this->roleService->createRoleByCompanyId($dto);

        return new JsonApiResponse(RoleResource::make($this->formater->formatRoleDtoToFrontend($role))->toArray($request),
            status: Response::HTTP_CREATED);
    }

    public function show(ShowCompanyRoleRequest $request)
    {
        $companyId = Uuid::fromString($request->get('companyId'));

        $roleId = Uuid::fromString($request->input('roleId'));
        $role = $this->roleService->getRoleByCompanyId($companyId, $roleId);

        return new JsonApiResponse(RoleResource::make($this->formater->formatRoleDtoToFrontend($role))->toArray($request),
            status: Response::HTTP_OK);
    }

    public function update(UpdateCompanyRoleRequest $request)
    {
        $dto = new UpdateRoleDto(
            Uuid::fromString($request->input('roleId')),
            Uuid::fromString($request->input('companyId')),
            $request->input('roleName'),
        );

        $role = $this->roleService->updateRoleByCompanyId($dto);

        return new JsonApiResponse(RoleResource::make($this->formater->formatRoleDtoToFrontend($role))->toArray($request),
            status: Response::HTTP_OK);
    }

    public function destroy(DeleteCompanyRoleRequest $request)
    {
        $companyId = Uuid::fromString($request->get('companyId'));

        $roleId = Uuid::fromString($request->input('roleId'));
        $this->roleService->deleteRoleByCompanyId($companyId, $roleId);

        return new JsonApiResponse([], status: Response::HTTP_OK);
    }

    public function getRolePermission(GetCompanyRolePermissionRequest $request)
    {
        $companyId = Uuid::fromString($request->get('companyId'));

        $roleId = Uuid::fromString($request->input('roleId'));

        $permissionIds = $this->roleService->getRolePermissions($companyId, $roleId);

        $dbPermissions = $this->permissionService->findMany($permissionIds);

        $permissions = [];
        foreach ($dbPermissions as $dbPermission) {
            $permissions[] = $this->formater->formatPermissionDtoToFrontend($dbPermission);
        }

        return new JsonApiResponse(PermissionResource::collection($permissions)->toArray($request),
            status: Response::HTTP_OK);
    }
}
