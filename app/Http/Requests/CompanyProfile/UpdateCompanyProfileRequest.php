<?php

namespace App\Http\Requests\CompanyProfile;

use Illuminate\Foundation\Http\FormRequest;

class UpdateCompanyProfileRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'companyId' => 'required|uuid',
            'profileId' => 'required|uuid',
            'profileName' => 'required|string',
        ];
    }

    public function authorize(): bool
    {
        return true;
    }

    protected function prepareForValidation(): void
    {
        $this->merge(['companyId' => $this->route('companyId')]);
        $this->merge(['profileId' => $this->route('profile')]);
    }
}
