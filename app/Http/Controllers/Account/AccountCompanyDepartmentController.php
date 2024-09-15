<?php

namespace App\Http\Controllers\Account;

use App\Http\Controllers\Controller;
use App\Http\Requests\CompanyDepartment\CreateCompanyDepartmentRequest;
use App\Http\Requests\CompanyDepartment\DeleteCompanyDepartmentRequest;
use App\Http\Requests\CompanyDepartment\IndexCompanyDepartmentRequest;
use App\Http\Requests\CompanyDepartment\ShowCompanyDepartmentRequest;
use App\Http\Requests\CompanyDepartment\UpdateCompanyDepartmentRequest;
use App\Http\Resources\DepartmentResource;
use App\Http\Responses\JsonApiResponse;
use App\Http\Responses\JsonErrorResponse;
use App\Services\Department\DepartmentService;
use App\Services\Department\Dto\CreateDepartmentDto;
use App\Services\Department\Dto\UpdateDepartmentDto;
use App\Services\User\UserService;
use Illuminate\Support\Facades\Auth;
use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;
use Symfony\Component\HttpFoundation\Response;

class AccountCompanyDepartmentController extends Controller
{
    public function __construct(
        private readonly UserService $userService,
        private readonly DepartmentService $departmentService,
    ) {
    }

    public function index(IndexCompanyDepartmentRequest $request)
    {
        $companyId = $this->checkUserCompany($request->input('companyId'));

        if (is_null($companyId)) {
            return new JsonErrorResponse(__('errors.company.not exists'), status: Response::HTTP_FORBIDDEN);
        }

        $departments = $this->departmentService->getDepartmentsByCompanyId($companyId);

        return new JsonApiResponse(DepartmentResource::collection($departments)->toArray($request),
            status: Response::HTTP_OK);
    }

    public function store(CreateCompanyDepartmentRequest $request)
    {
        $companyId = $this->checkUserCompany($request->input('companyId'));
        if (is_null($companyId)) {
            return new JsonErrorResponse(__('errors.company.not exists'), status: Response::HTTP_FORBIDDEN);
        }

        $dto = new CreateDepartmentDto(
            $companyId,
            $request->input('departmentName')
        );

        $Department = $this->departmentService->createDepartmentByCompanyId($dto);

        return new JsonApiResponse(DepartmentResource::make($Department)->toArray($request),
            status: Response::HTTP_CREATED);
    }

    public function show(ShowCompanyDepartmentRequest $request)
    {
        $companyId = $this->checkUserCompany($request->input('companyId'));
        if (is_null($companyId)) {
            return new JsonErrorResponse(__('errors.company.not exists'), status: Response::HTTP_FORBIDDEN);
        }

        $departmentId = Uuid::fromString($request->input('departmentId'));
        $Department = $this->departmentService->getDepartmentByCompanyId($companyId, $departmentId);

        return new JsonApiResponse(DepartmentResource::make($Department)->toArray($request), status: Response::HTTP_OK);
    }

    public function update(UpdateCompanyDepartmentRequest $request)
    {
        $companyId = $this->checkUserCompany($request->input('companyId'));
        if (is_null($companyId)) {
            return new JsonErrorResponse(__('errors.company.not exists'), status: Response::HTTP_FORBIDDEN);
        }

        $dto = new UpdateDepartmentDto(
            Uuid::fromString($request->input('departmentId')),
            Uuid::fromString($request->input('companyId')),
            $request->input('departmentName'),
        );

        $Department = $this->departmentService->updateDepartmentByCompanyId($dto);

        return new JsonApiResponse(DepartmentResource::make($Department)->toArray($request), status: Response::HTTP_OK);
    }

    public function destroy(DeleteCompanyDepartmentRequest $request)
    {
        $companyId = $this->checkUserCompany($request->input('companyId'));
        if (is_null($companyId)) {
            return new JsonErrorResponse(__('errors.company.not exists'), status: Response::HTTP_FORBIDDEN);
        }

        $departmentId = Uuid::fromString($request->input('departmentId'));
        $this->departmentService->deleteDepartmentByCompanyId($companyId, $departmentId);

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
