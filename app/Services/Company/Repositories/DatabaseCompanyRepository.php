<?php

namespace App\Services\Company\Repositories;

use App\Domain\ValueObjects\Email;
use App\Domain\ValueObjects\Inn;
use App\Domain\ValueObjects\Kpp;
use App\Domain\ValueObjects\Phone;
use App\Models\Company;
use App\Services\Company\Dto\CompanyDto;
use App\Services\Company\Dto\CreateCompanyDto;
use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;

final class DatabaseCompanyRepository implements CompanyRepository
{
    public function __construct()
    {
    }

    public function create(CreateCompanyDto $createCompanyDto): CompanyDto
    {
        $company = Company::create([
                'uuid' => Uuid::uuid4()->toString(),
                'name' => $createCompanyDto->getName(),
                'inn' => $createCompanyDto->getInn(),
                'kpp' => $createCompanyDto->getKpp(),
                'email' => $createCompanyDto->getEmail(),
                'phone' => $createCompanyDto->getPhone(),
                'website' => $createCompanyDto->getUrl(),
                'description' => $createCompanyDto->getDescription(),
                'is_active' => $createCompanyDto->isActive(),
            ]
        );

        return $this->formatCompanyDto($company);
    }

    /**
     * @param  UuidInterface  $companyId
     * @return CompanyDto
     */
    public function find(UuidInterface $companyId): CompanyDto
    {
        $dbCompany = Company::where('uuid', $companyId->toString())->firstOrFail();

        return $this->formatCompanyDto($dbCompany);
    }

    /**
     * @param  string[]  $companyIds
     * @return CompanyDto[]
     */
    public function findMany(array $companyIds): array
    {
        $dbCompanies = Company::whereIn('uuid', $companyIds)->get();

        $companies = [];
        foreach ($dbCompanies as $dbCompany) {
            $companies[] = $this->formatCompanyDto($dbCompany);
        }

        return $companies;
    }

    private function formatCompanyDto(Company $company): CompanyDto
    {
        return new CompanyDto(
            uuid: Uuid::fromString($company->uuid),
            name: $company->name,
            inn: Inn::create($company->inn),
            kpp: is_null($company->kpp) ? null : Kpp::create($company->kpp),
            email: Email::create($company->email),
            phone: Phone::create($company->phone),
            url: $company->website,
            description: $company->description,
            isActive: (bool)$company->is_active,
        );
    }
}
