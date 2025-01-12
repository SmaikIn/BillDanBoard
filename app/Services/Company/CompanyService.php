<?php

namespace App\Services\Company;

use App\Domain\ValueObjects\Email;
use App\Services\Company\Dto\CompanyDto;
use App\Services\Company\Dto\CreateCompanyDto;
use App\Services\Company\Dto\UpdateCompanyDto;
use Ramsey\Uuid\UuidInterface;

interface CompanyService
{
    /**
     * @param  UuidInterface  $companyId
     * @return CompanyDto
     */
    public function find(UuidInterface $companyId): CompanyDto;

    public function findMany(array $companyIds);

    public function delete(UuidInterface $companyId);

    public function create(CreateCompanyDto $createCompanyDto): CompanyDto;

    public function update(UpdateCompanyDto $updateCompanyDto);

    public function invite(UuidInterface $companyId, UuidInterface $userId, Email $email): void;
    public function accept(UuidInterface $companyId, string $code): bool;
}
