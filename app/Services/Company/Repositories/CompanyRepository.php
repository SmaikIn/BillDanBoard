<?php

namespace App\Services\Company\Repositories;

use App\Services\Company\Dto\CompanyDto;
use App\Services\Company\Dto\CreateCompanyDto;
use Ramsey\Uuid\UuidInterface;

interface CompanyRepository
{

    /**
     * @param  UuidInterface  $companyId
     * @return CompanyDto
     */
    public function find(UuidInterface $companyId):CompanyDto;

    /**
     * @param  CreateCompanyDto  $createCompanyDto
     * @return CompanyDto
     */
    public function create(CreateCompanyDto $createCompanyDto): CompanyDto;

    /**
     * @param  array  $companyIds
     * @return CompanyDto[]
     */
    public function findMany(array $companyIds): array;

}
