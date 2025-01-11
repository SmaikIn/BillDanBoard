<?php

namespace App\Http\Controllers\Account;

use App\Domain\ValueObjects\Email;
use App\Dto\CompanyDto as CompanyFrontend;
use App\Dto\DepartmentDto as DepartmentFrontend;
use App\Dto\ProfileDto as ProfileFrontend;
use App\Dto\RoleDto as RoleFrontend;
use App\Dto\UserDto as UserFrontend;
use App\Http\Controllers\Controller;
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
use App\Services\Company\Dto\CompanyDto;
use App\Services\Department\DepartmentService;
use App\Services\Department\Dto\DepartmentDto;
use App\Services\Profile\Dto\ProfileDto;
use App\Services\Profile\Dto\UpdateProfileDto;
use App\Services\Profile\ProfileService;
use App\Services\Role\Dto\RoleDto;
use App\Services\Role\RoleService;
use App\Services\User\Dto\UserDto;
use App\Services\User\UserService;
use Illuminate\Support\Facades\Auth;
use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;
use Symfony\Component\HttpFoundation\Response;

class AccountCompanyProfileController extends Controller
{
    public function __construct(
        private readonly UserService $userService,
        private readonly CompanyService $companyService,
        private readonly RoleService $roleService,
        private readonly DepartmentService $departmentService,
        private readonly ProfileService $profileService,
    ) {
    }

    public function index(IndexCompanyProfileRequest $request)
    {
        $companyId = $this->checkUserCompany($request->input('companyId'));

        if (is_null($companyId)) {
            return new JsonErrorResponse(__('errors.company.not exists'), status: Response::HTTP_FORBIDDEN);
        }

        $dbProfiles = $this->profileService->getProfilesByCompanyId($companyId);

        $profiles = [];
        foreach ($dbProfiles as $dbProfile) {
            $profiles[] = $this->formatProfileDtoToFrontend($dbProfile);
        }

        return new JsonApiResponse(ProfileResource::collection($profiles)->toArray($request),
            status: Response::HTTP_OK);
    }

    public function show(ShowCompanyProfileRequest $request)
    {
        $companyId = $this->checkUserCompany($request->input('companyId'));
        if (is_null($companyId)) {
            return new JsonErrorResponse(__('errors.company.not exists'), status: Response::HTTP_FORBIDDEN);
        }

        $profileId = Uuid::fromString($request->input('profileId'));
        $profile = $this->formatProfileDtoToFrontend($this->profileService->getProfileByCompanyId($companyId,
            $profileId));

        return new JsonApiResponse(ProfileResource::make($profile)->toArray($request), status: Response::HTTP_OK);
    }

    public function update(UpdateCompanyProfileRequest $request)
    {
        $companyId = $this->checkUserCompany($request->input('companyId'));
        if (is_null($companyId)) {
            return new JsonErrorResponse(__('errors.company.not exists'), status: Response::HTTP_FORBIDDEN);
        }

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
        $companyId = $this->checkUserCompany($request->input('companyId'));
        if (is_null($companyId)) {
            return new JsonErrorResponse(__('errors.company.not exists'), status: Response::HTTP_FORBIDDEN);
        }

        $roleId = Uuid::fromString($request->input('profileId'));
        $this->profileService->deleteProfileByCompanyId($companyId, $roleId);

        return new JsonApiResponse([], status: Response::HTTP_OK);
    }

    public function inviteUserToCompany(InviteCompanyProfileRequest $request)
    {
        $companyId = $this->checkUserCompany($request->input('companyId'));
        if (is_null($companyId)) {
            return new JsonErrorResponse(__('errors.company.not exists'), status: Response::HTTP_FORBIDDEN);
        }

        $userId = Uuid::fromString(Auth::id());;
        $email = Email::create($request->input('email'));

        $this->companyService->invite($companyId, $userId, $email);

        return new JsonApiResponse([], status: Response::HTTP_ACCEPTED);
    }

    public function acceptUserToCompany(AcceptCompanyProfileRequest $request)
    {
        $code = $request->input('code');
        $companyId = $request->input('companyId');

        $flag = $this->companyService->accept($companyId, $code);

        if ($flag) {
            return new JsonApiResponse([], status: Response::HTTP_ACCEPTED);
        }

        return new JsonErrorResponse(__('errors.code'), status: Response::HTTP_FORBIDDEN);
    }

    public function banProfile(BanCompanyProfileRequest $request)
    {
        $companyId = $this->checkUserCompany($request->input('companyId'));
        $profileId = Uuid::fromString($request->input('profileId'));

        //TODO add permission
        $flag = $this->profileService->banProfile($companyId, $profileId);

        if ($flag) {
            return new JsonApiResponse([], status: Response::HTTP_ACCEPTED);
        }

        return new JsonErrorResponse(__('errors.code'), status: Response::HTTP_FORBIDDEN);
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

    private function formatProfileDtoToFrontend(ProfileDto $dbProfile): ProfileFrontend
    {
        return new ProfileFrontend(
            id: $dbProfile->getId(),
            userDto: $this->formatUserDtoToFrontend($this->userService->find($dbProfile->getUserId())),
            companyDto: $this->formatCompanyDtoToFrontend(($this->companyService->find($dbProfile->getCompanyId()))),
            roleDto: $this->formatRoleDtoToFrontend($this->roleService->getRoleByCompanyId($dbProfile->getCompanyId(),
                $dbProfile->getRoleId())),
            departmentDto: $this->formatDepartmentDtoToFrontend($this->departmentService->getDepartmentByCompanyId($dbProfile->getCompanyId(),
                $dbProfile->getDepartmentId())),
            firstName: $dbProfile->getFirstName(),
            lastName: $dbProfile->getLastName(),
            secondName: $dbProfile->getSecondName(),
            phone: $dbProfile->getPhone(),
            photo: $dbProfile->getPhoto(),
            email: $dbProfile->getEmail(),
            birthday: $dbProfile->getBirthday(),
            createdAt: $dbProfile->getCreatedAt(),
        );
    }

    private function formatUserDtoToFrontend(UserDto $userDto)
    {
        return new UserFrontend(
            id: $userDto->getId(),
            firstName: $userDto->getFirstName(),
            lastName: $userDto->getLastName(),
            secondName: $userDto->getSecondName(),
            phone: $userDto->getPhone(),
            photo: $userDto->getPhoto(),
            email: $userDto->getEmail(),
            yandexId: $userDto->getYandexId(),
            birthday: $userDto->getBirthday(),
            createdAt: $userDto->getCreatedAt(),
        );
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

    private function formatRoleDtoToFrontend(RoleDto $roleDto): RoleFrontend
    {
        return new RoleFrontend(
            uuid: $roleDto->getId(),
            companyUuid: $roleDto->getCompanyId(),
            name: $roleDto->getName(),
            createdAt: $roleDto->getCreatedAt(),
        );
    }

    private function formatDepartmentDtoToFrontend(DepartmentDto $departmentDto): DepartmentFrontend
    {
        return new DepartmentFrontend(
            uuid: $departmentDto->getId(),
            companyUuid: $departmentDto->getCompanyId(),
            name: $departmentDto->getName(),
            createdAt: $departmentDto->getCreatedAt(),
        );
    }


}
