<?php

namespace App\Http\Controllers\Account;

use App\Enum\Resource;
use App\Http\Checker\Checker;
use App\Http\Controllers\Controller;
use App\Http\Formater\Formater;
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
use Ramsey\Uuid\Uuid;
use Symfony\Component\HttpFoundation\Response;

class AccountCompanyDepartmentController extends Controller
{
    public function __construct(
        private readonly DepartmentService $departmentService,
        private readonly Formater $formater,
    ) {
    }

    public function index(IndexCompanyDepartmentRequest $request)
    {
        $companyId = Uuid::fromString($request->input('company_id'));

        $dbDepartments = $this->departmentService->getDepartmentsByCompanyId($companyId);

        $departments = [];
        foreach ($dbDepartments as $dbDepartment) {
            $departments[] = $this->formater->formatDepartmentDtoToFrontend($dbDepartment);
        }

        $pagination = $this->formater->formatPagination($departments, Resource::Department, $request->get('page', 1));

        return new JsonApiResponse($pagination->toArray($request), status: Response::HTTP_OK);
    }

    public function store(CreateCompanyDepartmentRequest $request)
    {
        $companyId = Uuid::fromString($request->input('company_id'));

        $dto = new CreateDepartmentDto(
            $companyId,
            $request->input('departmentName')
        );

        $department = $this->departmentService->createDepartmentByCompanyId($dto);

        return new JsonApiResponse(DepartmentResource::make($this->formater->formatDepartmentDtoToFrontend($department))->toArray($request),
            status: Response::HTTP_CREATED);
    }

    public function show(ShowCompanyDepartmentRequest $request)
    {
        $companyId = Uuid::fromString($request->input('company_id'));

        $departmentId = Uuid::fromString($request->input('departmentId'));
        $department = $this->departmentService->getDepartmentByCompanyId($companyId, $departmentId);

        return new JsonApiResponse(DepartmentResource::make($this->formater->formatDepartmentDtoToFrontend($department))->toArray($request),
            status: Response::HTTP_OK);
    }

    public function update(UpdateCompanyDepartmentRequest $request)
    {
        $dto = new UpdateDepartmentDto(
            Uuid::fromString($request->input('departmentId')),
            Uuid::fromString($request->input('companyId')),
            $request->input('departmentName'),
        );

        $department = $this->departmentService->updateDepartmentByCompanyId($dto);

        return new JsonApiResponse(DepartmentResource::make($this->formater->formatDepartmentDtoToFrontend($department))->toArray($request),
            status: Response::HTTP_OK);
    }

    public function destroy(DeleteCompanyDepartmentRequest $request)
    {
        $companyId = Uuid::fromString($request->input('company_id'));

        $departmentId = Uuid::fromString($request->input('departmentId'));
        $this->departmentService->deleteDepartmentByCompanyId($companyId, $departmentId);

        return new JsonApiResponse([], status: Response::HTTP_OK);
    }
}
