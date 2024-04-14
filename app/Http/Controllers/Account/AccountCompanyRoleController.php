<?php

namespace App\Http\Controllers\Account;

use App\Http\Controllers\Controller;
use App\Http\Requests\CompanyRole\DeleteCompanyRoleRequest;
use App\Http\Requests\CompanyRole\IndexCompanyRoleRequest;
use App\Http\Requests\CompanyRole\ShowCompanyRoleRequest;
use App\Http\Requests\RoleRequest;
use App\Http\Resources\RoleResource;
use App\Http\Responses\JsonApiResponse;
use App\Http\Responses\JsonErrorResponse;
use App\Models\Role;
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
    ) {
    }

    public function index(IndexCompanyRoleRequest $request)
    {
        $companyId = $this->checkUserCompany($request->company_id);

        if (is_null($companyId)) {
            return new JsonErrorResponse(__('errors.company.not exists'), status: Response::HTTP_FORBIDDEN);
        }

        $roles = $this->roleService->getRolesByCompanyId($companyId);

        return new JsonApiResponse(RoleResource::collection($roles)->toArray($request), status: Response::HTTP_OK);
    }

    public function store(RoleRequest $request)
    {
        return new RoleResource(Role::create($request->validated()));
    }

    public function show(ShowCompanyRoleRequest $request)
    {
        $companyId = $this->checkUserCompany($request->company_id);
        $roleId = Uuid::fromString($request->role_id);

        if (is_null($companyId)) {
            return new JsonErrorResponse(__('errors.company.not exists'), status: Response::HTTP_FORBIDDEN);
        }

        $role = $this->roleService->getRoleByCompanyId($companyId, $roleId);

        return new JsonApiResponse(RoleResource::make($role)->toArray($request), status: Response::HTTP_OK);
    }

    public function update(RoleRequest $request, Role $role)
    {
        $role->update($request->validated());

        return new RoleResource($role);
    }

    public function destroy(DeleteCompanyRoleRequest $request)
    {
        $companyId = $this->checkUserCompany($request->company_id);
        $roleId = Uuid::fromString($request->role_id);

        if (is_null($companyId)) {
            return new JsonErrorResponse(__('errors.company.not exists'), status: Response::HTTP_FORBIDDEN);
        }

        $this->roleService->deleteRoleByCompanyId($companyId, $roleId);

        return new JsonApiResponse([], status: Response::HTTP_OK);
    }


    private function checkUserCompany(string $companyId): ?UuidInterface
    {
        $userId = Uuid::fromString(Auth::id());

        $companyIds = $this->userService->getCompanyIds($userId);

        $key = array_search($companyId, $companyIds);

        if (!$key) {
            return null;
        }

        return Uuid::fromString($companyIds[$key]);
    }
}
