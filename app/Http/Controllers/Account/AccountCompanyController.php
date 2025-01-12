<?php

namespace App\Http\Controllers\Account;

use App\Dto\CompanyDto as CompanyFrontend;
use App\Http\Controllers\Controller;
use App\Http\Requests\Company\CreateCompanyRequest;
use App\Http\Requests\Company\DeleteCompanyRequest;
use App\Http\Requests\Company\ShowCompanyRequest;
use App\Http\Requests\Company\UpdateCompanyRequest;
use App\Http\Resources\CompanyResource;
use App\Http\Responses\JsonApiResponse;
use App\Http\Responses\JsonErrorResponse;
use App\Services\Company\CompanyService;
use App\Services\Company\Dto\CompanyDto;
use App\Services\User\UserService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;
use Symfony\Component\HttpFoundation\Response;

class AccountCompanyController extends Controller
{
    public function __construct(
        private readonly UserService $userService,
        private readonly CompanyService $companyService
    ) {
    }

    public function index(Request $request)
    {
        $userId = Uuid::fromString(Auth::id());

        $companiesIds = $this->userService->getCompanyIds($userId);

        $dbCompanies = $this->companyService->findMany($companiesIds);

        $companies = [];
        foreach ($dbCompanies as $company) {
            $companies[] = $this->formatCompanyDtoToFrontend($company);
        }

        $companyCollection = CompanyResource::collection($companies);

        return new JsonApiResponse($companyCollection->toArray($request));
    }

    public function store(CreateCompanyRequest $request)
    {
        $userId = Uuid::fromString(Auth::id());

        $createCompanyDto = $request->getDto();

        $company = $this->companyService->create($createCompanyDto);

        //TODO profileService create profile in company

        return new JsonApiResponse((CompanyResource::make($this->formatCompanyDtoToFrontend($company)))->toArray($request));
    }

    public function show(ShowCompanyRequest $request)
    {
        $companyId = Uuid::fromString($request->get('uuid'));

        $exists = $this->checkUserCompany($companyId);
        if (!$exists) {
            return new JsonErrorResponse(__('errors.company.not exists'), status: Response::HTTP_FORBIDDEN);
        }

        $company = $this->companyService->find($companyId);

        return new JsonApiResponse((CompanyResource::make($this->formatCompanyDtoToFrontend($company)))->toArray($request));
    }

    public function update(UpdateCompanyRequest $request)
    {
        $updateCompanyDto = $request->getDto();

        $exists = $this->checkUserCompany(Uuid::fromString($request->get('uuid')));
        if (!$exists) {
            return new JsonErrorResponse(__('errors.company.not exists'), status: Response::HTTP_FORBIDDEN);
        }
        //TODO profileService update check

        $company = $this->companyService->update($updateCompanyDto);

        return new JsonApiResponse((CompanyResource::make($this->formatCompanyDtoToFrontend($company)))->toArray($request));
    }

    public function destroy(DeleteCompanyRequest $request)
    {
        $companyId = Uuid::fromString($request->get('uuid'));

        $exists = $this->checkUserCompany($companyId);
        if (!$exists) {
            return new JsonErrorResponse(__('errors.company.not exists'), status: Response::HTTP_FORBIDDEN);
        }
        //TODO profileService destroy check

        $result = $this->companyService->delete($companyId);

        if (!$result) {
            return new JsonErrorResponse(__('errors.company.wrong'), status: Response::HTTP_CONFLICT);
        }

        return new JsonApiResponse([]);
    }

    private function checkUserCompany(UuidInterface $id): bool
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

    private function formatCompanyDtoToFrontend(CompanyDto $companyDto): CompanyFrontend
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
}
