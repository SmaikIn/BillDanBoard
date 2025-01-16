<?php

namespace App\Http\Controllers\Account;

use App\Domain\ValueObjects\Email;
use App\Enum\Resource;
use App\Http\Controllers\Controller;
use App\Http\Formater\Formater;
use App\Http\Requests\CompanyProfile\AcceptCompanyProfileRequest;
use App\Http\Requests\CompanyProfile\BanCompanyProfileRequest;
use App\Http\Requests\CompanyProfile\DeleteCompanyProfileRequest;
use App\Http\Requests\CompanyProfile\IndexCompanyProfileRequest;
use App\Http\Requests\CompanyProfile\InviteCompanyProfileRequest;
use App\Http\Requests\CompanyProfile\ShowCompanyProfileRequest;
use App\Http\Requests\CompanyProfile\UpdateCompanyProfileRequest;
use App\Http\Resources\ProfileResource;
use App\Http\Responses\JsonApiResponse;
use App\Http\Responses\JsonErrorResponse;
use App\Services\Company\CompanyService;
use App\Services\Profile\Dto\UpdateProfileDto;
use App\Services\Profile\ProfileService;
use Illuminate\Support\Facades\Auth;
use Ramsey\Uuid\Uuid;
use Symfony\Component\HttpFoundation\Response;

class AccountCompanyProfileController extends Controller
{
    public function __construct(
        private readonly CompanyService $companyService,
        private readonly ProfileService $profileService,
        private readonly Formater $formater,
    ) {
    }

    public function index(IndexCompanyProfileRequest $request)
    {
        $companyId = Uuid::fromString($request->get('companyId'));

        $dbProfiles = $this->profileService->getProfilesByCompanyId($companyId);

        $profiles = [];
        foreach ($dbProfiles as $dbProfile) {
            $profiles[] = $this->formater->formatProfileDtoToFrontend($dbProfile);
        }

        $pagination = $this->formater->formatPagination($profiles, Resource::Profile, $request->get('page', 1));

        return new JsonApiResponse($pagination->toArray($request), status: Response::HTTP_OK);
    }

    public function show(ShowCompanyProfileRequest $request)
    {
        $companyId = Uuid::fromString($request->get('companyId'));

        $profileId = Uuid::fromString($request->input('profileId'));
        $dbProfile = $this->profileService->getProfileByCompanyId($companyId, $profileId);

        $profile = $this->formater->formatProfileDtoToFrontend($dbProfile);

        return new JsonApiResponse(ProfileResource::make($profile)->toArray($request), status: Response::HTTP_OK);
    }

    public function update(UpdateCompanyProfileRequest $request)
    {
        $dto = new UpdateProfileDto(
            Uuid::fromString($request->input('profileId')),
            Uuid::fromString($request->input('companyId')),
            $request->input('profileName'),
        );

        $profile = $this->profileService->updateProfileByCompanyId($dto);

        return new JsonApiResponse(ProfileResource::make($profile)->toArray($request), status: Response::HTTP_OK);
    }

    public function destroy(DeleteCompanyProfileRequest $request)
    {
        $companyId = Uuid::fromString($request->get('companyId'));

        $roleId = Uuid::fromString($request->input('profileId'));
        $this->profileService->deleteProfileByCompanyId($companyId, $roleId);

        return new JsonApiResponse([], status: Response::HTTP_OK);
    }

    public function inviteUserToCompany(InviteCompanyProfileRequest $request)
    {
        $companyId = Uuid::fromString($request->get('companyId'));

        $userId = Uuid::fromString(Auth::id());;
        $email = Email::create($request->input('email'));

        $this->companyService->invite($companyId, $userId, $email);

        return new JsonApiResponse([], status: Response::HTTP_ACCEPTED);
    }

    public function acceptUserToCompany(AcceptCompanyProfileRequest $request)
    {
        $code = $request->input('code');
        $companyId = Uuid::fromString($request->input('companyId'));

        $flag = $this->companyService->accept($companyId, $code);

        if ($flag) {
            return new JsonApiResponse([], status: Response::HTTP_ACCEPTED);
        }

        return new JsonErrorResponse(__('errors.code'), status: Response::HTTP_FORBIDDEN);
    }

    public function banProfile(BanCompanyProfileRequest $request)
    {
        $companyId = Uuid::fromString($request->get('companyId'));
        $profileId = Uuid::fromString($request->input('profileId'));

        //TODO add permission
        $flag = $this->profileService->banProfile($companyId, $profileId);

        if ($flag) {
            return new JsonApiResponse([], status: Response::HTTP_ACCEPTED);
        }

        return new JsonErrorResponse(__('errors.code'), status: Response::HTTP_FORBIDDEN);
    }
}
