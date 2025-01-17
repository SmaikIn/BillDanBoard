<?php

namespace App\Http\Requests\Company;

use App\Domain\ValueObjects\Email;
use App\Domain\ValueObjects\Inn;
use App\Domain\ValueObjects\Kpp;
use App\Domain\ValueObjects\Phone;
use App\Services\Company\Dto\UpdateCompanyDto;
use Illuminate\Foundation\Http\FormRequest;
use Ramsey\Uuid\Uuid;

class UpdateCompanyRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'uuid' => 'required|uuid',
            'name' => 'required|string|max:255',
            'inn' => 'required|string|max:12',
            'kpp' => 'nullable|string|max:9',
            'email' => 'required|email|unique:companies,email',
            'phone' => 'required|string|max:20|unique:companies,phone',
            'website' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'isActive' => 'nullable|bool',
        ];
    }

    public function authorize(): bool
    {
        return true;
    }

    protected function prepareForValidation(): void
    {
        $this->merge(['uuid' => $this->route('companyId')]);
    }

    public function getDto(): UpdateCompanyDto
    {
        return new UpdateCompanyDto(
            uuid: Uuid::fromString($this->get('uuid')),
            name: $this->get('name'),
            inn: Inn::create($this->get('inn')),
            kpp: $this->exists('kpp') ? Kpp::create($this->get('kpp')) : null,
            email: Email::create($this->get('email')),
            phone: Phone::create($this->get('phone')),
            url: $this->get('website'),
            description: $this->get('description'),
            isActive: $this->get('isActive', true),
        );
    }
}
