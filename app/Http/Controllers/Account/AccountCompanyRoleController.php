<?php

namespace App\Http\Controllers\Account;

use App\Http\Controllers\Controller;
use App\Http\Requests\CompanyRole\CreateCompanyRoleRequest;
use App\Http\Requests\CompanyRole\DeleteCompanyRoleRequest;
use App\Http\Requests\CompanyRole\IndexCompanyRoleRequest;
use App\Http\Requests\CompanyRole\ShowCompanyRoleRequest;
use App\Http\Requests\CompanyRole\UpdateCompanyRoleRequest;
use App\Http\Resources\RoleResource;
use App\Http\Responses\JsonApiResponse;
use App\Http\Responses\JsonErrorResponse;
use App\Services\Role\Dto\CreateRoleDto;
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
    ) {
    }

    public function index(IndexCompanyRoleRequest $request)
    {
        $companyId = $this->checkUserCompany($request->input('companyId'));

        if (is_null($companyId)) {
            return new JsonErrorResponse(__('errors.company.not exists'), status: Response::HTTP_FORBIDDEN);
        }

        $roles = $this->roleService->getRolesByCompanyId($companyId);

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

        return new JsonApiResponse(RoleResource::make($role)->toArray($request), status: Response::HTTP_CREATED);
    }

    public function show(ShowCompanyRoleRequest $request)
    {
        $companyId = $this->checkUserCompany($request->input('companyId'));
        if (is_null($companyId)) {
            return new JsonErrorResponse(__('errors.company.not exists'), status: Response::HTTP_FORBIDDEN);
        }

        $roleId = Uuid::fromString($request->input('roleId'));
        $role = $this->roleService->getRoleByCompanyId($companyId, $roleId);

        return new JsonApiResponse(RoleResource::make($role)->toArray($request), status: Response::HTTP_OK);
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

        return new JsonApiResponse(RoleResource::make($role)->toArray($request), status: Response::HTTP_OK);
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
