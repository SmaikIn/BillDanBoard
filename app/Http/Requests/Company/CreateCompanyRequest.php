<?php

namespace App\Http\Requests\Company;

use App\Domain\ValueObjects\Email;
use App\Domain\ValueObjects\Inn;
use App\Domain\ValueObjects\Kpp;
use App\Domain\ValueObjects\Phone;
use App\Services\Company\Dto\CreateCompanyDto;
use Illuminate\Foundation\Http\FormRequest;

class CreateCompanyRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'inn' => 'required|string|max:12',
            'kpp' => 'nullable|string|max:9',
            'email' => 'required|email|unique:companies,email',
            'phone' => 'required|string|max:20|unique:companies,phone',
            'website' => 'nullable|string|max:255',
            'description' => 'nullable|string',
        ];
    }

    public function authorize(): bool
    {
        return true;
    }

    public function getDto(): CreateCompanyDto
    {
        return new CreateCompanyDto(
            name: $this->get('name'),
            inn: Inn::create($this->get('inn')),
            kpp: $this->exists('kpp') ? Kpp::create($this->get('kpp')) : null,
            email: Email::create($this->get('email')),
            phone: Phone::create($this->get('phone')),
            url: $this->get('website'),
            description: $this->get('description'),
        );
    }
}
