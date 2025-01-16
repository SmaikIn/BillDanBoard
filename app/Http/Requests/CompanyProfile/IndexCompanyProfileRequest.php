<?php

namespace App\Http\Requests\CompanyProfile;

use Illuminate\Foundation\Http\FormRequest;

class IndexCompanyProfileRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'companyId' => 'required|uuid',
            'page' => 'integer',
        ];
    }

    public function authorize(): bool
    {
        return true;
    }

    protected function prepareForValidation(): void
    {
        $this->merge(['companyId' => $this->route('companyId')]);
    }
}
