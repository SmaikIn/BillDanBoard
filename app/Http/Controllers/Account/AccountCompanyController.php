<?php

namespace App\Http\Controllers\Account;

use App\Http\Controllers\Controller;
use App\Http\Requests\CompanyRequest;
use App\Http\Resources\CompanyResource;
use App\Http\Responses\JsonApiResponse;
use App\Services\Company\CompanyService;
use App\Services\User\UserService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Ramsey\Uuid\Uuid;

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

        $companies = $this->companyService->findMany($companiesIds);

        $companyCollection = CompanyResource::collection($companies);

        return new JsonApiResponse($companyCollection->toArray($request));
    }

    public function store(CompanyRequest $request)
    {
        $userId = Uuid::fromString(Auth::id());

        $createCompanyDto = $request->getDto();

        $this->companyService->create($createCompanyDto);
        //TODO profileService

    }

    public function show($id)
    {
    }

    public function update(Request $request, $id)
    {
    }

    public function destroy($id)
    {
    }
}
