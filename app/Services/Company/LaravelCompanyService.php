<?php

namespace App\Services\Company;

use App\Domain\ValueObjects\Email;
use App\Services\Company\Dto\CompanyDto;
use App\Services\Company\Dto\CreateCompanyDto;
use App\Services\Company\Dto\UpdateCompanyDto;
use App\Services\Company\Events\CreateCompanyEvent;
use App\Services\Company\Events\InviteUserToCompanyEvent;
use App\Services\Company\Repositories\CompanyRepository;
use Illuminate\Events\Dispatcher;
use Ramsey\Uuid\UuidInterface;

final readonly class LaravelCompanyService implements CompanyService
{
    public function __construct(
        private Dispatcher $dispatcher,
        private CompanyRepository $companyRepository
    ) {
    }

    public function find(UuidInterface $companyId): CompanyDto
    {
        return $this->companyRepository->find($companyId);
    }

    /**
     * @param  array  $companyIds
     * @return CompanyDto[]
     */
    public function findMany(array $companyIds): array
    {
        return $this->companyRepository->findMany($companyIds);
    }


    public function create(CreateCompanyDto $createCompanyDto):CompanyDto
    {
        $company = $this->companyRepository->create($createCompanyDto);

        $this->dispatcher->dispatch(new CreateCompanyEvent($company->getUuid()));

        return $company;
    }

    public function update(UpdateCompanyDto $updateCompanyDto): CompanyDto
    {
        return $this->companyRepository->update($updateCompanyDto);
    }

    public function delete(UuidInterface $companyId): bool
    {
        return $this->companyRepository->delete($companyId);
    }

    public function invite(UuidInterface $companyId, UuidInterface $userId, Email $email): void
    {
        $code = \Str::random(30);

        $this->companyRepository->setInviteCode($code);

        $this->dispatcher->dispatch(new InviteUserToCompanyEvent($companyId, $userId, $email, $code));
    }

    public function accept(UuidInterface $companyId, string $code): bool
    {
        $checkCode = $this->companyRepository->getInviteCode($code);

        if (is_null($checkCode)) {
            return false;
        }

        $this->companyRepository->forgetInviteCode($code);

        return true;
    }
}
