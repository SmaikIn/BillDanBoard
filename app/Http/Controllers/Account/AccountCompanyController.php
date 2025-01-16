<?php

namespace App\Http\Controllers\Account;

use App\Enum\Resource;
use App\Http\Controllers\Controller;
use App\Http\Formater\Formater;
use App\Http\Requests\Company\CreateCompanyRequest;
use App\Http\Requests\Company\DeleteCompanyRequest;
use App\Http\Requests\Company\IndexCompanyRequest;
use App\Http\Requests\Company\ShowCompanyRequest;
use App\Http\Requests\Company\UpdateCompanyRequest;
use App\Http\Resources\CompanyResource;
use App\Http\Responses\JsonApiResponse;
use App\Http\Responses\JsonErrorResponse;
use App\Services\Company\CompanyService;
use App\Services\Department\DepartmentService;
use App\Services\Department\Dto\CreateDepartmentDto;
use App\Services\Permission\PermissionService;
use App\Services\Profile\Dto\CreateProfileDto;
use App\Services\Profile\ProfileService;
use App\Services\Role\Dto\CreateRoleDto;
use App\Services\Role\RoleService;
use App\Services\User\UserService;
use Illuminate\Support\Facades\Auth;
use Ramsey\Uuid\Uuid;
use Symfony\Component\HttpFoundation\Response;

class AccountCompanyController extends Controller
{
    public function __construct(
        private readonly UserService $userService,
        private readonly CompanyService $companyService,
        private readonly RoleService $roleService,
        private readonly DepartmentService $departmentService,
        private readonly PermissionService $permissionService,
        private readonly ProfileService $profileService,
        private readonly Formater $formater,
    ) {
    }

    public function index(IndexCompanyRequest $request)
    {
        $userId = Uuid::fromString(Auth::id());

        $companiesIds = $this->userService->getCompanyIds($userId);

        $dbCompanies = $this->companyService->findMany($companiesIds);

        $companies = [];
        foreach ($dbCompanies as $company) {
            $companies[] = $this->formater->formatCompanyDtoToFrontend($company);
        }

        $pagination = $this->formater->formatPagination($companies, Resource::Company, $request->get('page', 1));

        return new JsonApiResponse($pagination->toArray($request), status: Response::HTTP_OK);
    }

    public function store(CreateCompanyRequest $request)
    {
        $userId = Uuid::fromString(Auth::id());
        $user = $this->userService->find($userId);

        $createCompanyDto = $request->getDto();
        $company = $this->companyService->create($createCompanyDto);

        $this->userService->appendCompanyToUser($company->getUuid(), $user->getId());


        $createDepartmentDto = new CreateDepartmentDto(
            $company->getUuid(),
            "Администрация"
        );
        $department = $this->departmentService->createDepartmentByCompanyId($createDepartmentDto);


        $createRoleDto = new CreateRoleDto(
            $company->getUuid(),
            "Генеральный Директор"
        );
        $role = $this->roleService->createRoleByCompanyId($createRoleDto);


        $dbPermissions = $this->permissionService->all();
        $permissionsIds = [];
        foreach ($dbPermissions as $permission) {
            $permissionsIds[] = $permission->getUuid()->toString();
        }
        $this->roleService->appendPermissionsToRole($role->getId(), $permissionsIds);


        $createProfileDto = new CreateProfileDto(
            userId: $user->getId(),
            companyId: $company->getUuid(),
            roleId: $role->getId(),
            departmentId: $department->getId(),
            firstName: $user->getFirstName(),
            lastName: $user->getLastName(),
            secondName: $user->getSecondName(),
            phone: $user->getPhone(),
            photo: $user->getPhoto(),
            email: $user->getEmail(),
            birthday: $user->getBirthday(),
        );
        $profile = $this->profileService->createProfile($createProfileDto);

        return new JsonApiResponse((CompanyResource::make($this->formater->formatCompanyDtoToFrontend($company)))->toArray($request));
    }

    public function show(ShowCompanyRequest $request)
    {
        $companyId = Uuid::fromString($request->get('uuid'));

        $company = $this->companyService->find($companyId);

        return new JsonApiResponse((CompanyResource::make($this->formater->formatCompanyDtoToFrontend($company)))->toArray($request));
    }

    public function update(UpdateCompanyRequest $request)
    {
        $updateCompanyDto = $request->getDto();

        $user = $this->userService->firstUserInCompany($updateCompanyDto->getUuid());

        if ($user->getId() != Auth::id()) {
            return new JsonErrorResponse(__('errors.company.update'), status: Response::HTTP_FORBIDDEN);
        }

        $company = $this->companyService->update($updateCompanyDto);

        return new JsonApiResponse((CompanyResource::make($this->formater->formatCompanyDtoToFrontend($company)))->toArray($request));
    }

    public function destroy(DeleteCompanyRequest $request)
    {
        $companyId = Uuid::fromString($request->get('uuid'));

        $user = $this->userService->firstUserInCompany($companyId);

        if ($user->getId() != Auth::id()) {
            return new JsonErrorResponse(__('errors.company.update'), status: Response::HTTP_FORBIDDEN);
        }

        $result = $this->companyService->delete($companyId);

        if (!$result) {
            return new JsonErrorResponse(__('errors.company.wrong'), status: Response::HTTP_CONFLICT);
        }

        return new JsonApiResponse([]);
    }


}
