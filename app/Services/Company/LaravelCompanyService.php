<?php

namespace App\Services\Company;

use App\Services\Company\Dto\CompanyDto;
use App\Services\Company\Dto\CreateCompanyDto;
use App\Services\Company\Events\CreateCompanyEvent;
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


    public function create(CreateCompanyDto $createCompanyDto)
    {
        $company = $this->companyRepository->create($createCompanyDto);

        $this->dispatcher->dispatch(new CreateCompanyEvent($company->getUuid()));

        return $company;
    }

    public function update()
    {
        return null;
    }

    public function delete()
    {
        return null;
    }
}
