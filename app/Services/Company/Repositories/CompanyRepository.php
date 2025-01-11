<?php

namespace App\Services\Company\Repositories;

use App\Services\Company\Dto\CompanyDto;
use App\Services\Company\Dto\CreateCompanyDto;
use App\Services\Company\Dto\UpdateCompanyDto;
use Ramsey\Uuid\UuidInterface;

interface CompanyRepository
{

    /**
     * @param  UuidInterface  $companyId
     * @return CompanyDto
     */
    public function find(UuidInterface $companyId): CompanyDto;

    /**
     * @param  CreateCompanyDto  $createCompanyDto
     * @return CompanyDto
     */
    public function create(CreateCompanyDto $createCompanyDto): CompanyDto;

    public function update(UpdateCompanyDto $updateCompanyDto): CompanyDto;

    public function delete(UuidInterface $companyId): bool;


    /**
     * @param  array  $companyIds
     * @return CompanyDto[]
     */
    public function findMany(array $companyIds): array;

    public function getInviteCode(string $code): ?string;

    public function setInviteCode(string $code): void;
    public function forgetInviteCode(string $code): void;

}
