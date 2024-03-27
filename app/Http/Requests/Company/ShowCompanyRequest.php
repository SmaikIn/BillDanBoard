<?php

namespace App\Http\Requests\Company;

use App\Domain\ValueObjects\Email;
use App\Domain\ValueObjects\Inn;
use App\Domain\ValueObjects\Kpp;
use App\Domain\ValueObjects\Phone;
use App\Services\Company\Dto\UpdateCompanyDto;
use Illuminate\Foundation\Http\FormRequest;
use Ramsey\Uuid\Uuid;

class ShowCompanyRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'uuid' => 'required|uuid',
        ];
    }

    public function authorize(): bool
    {
        return true;
    }

    protected function prepareForValidation(): void
    {
        $this->merge(['uuid' => $this->route('company')]);
    }
}
