<?php

namespace App\Http\Requests\CompanyRole;

use Illuminate\Foundation\Http\FormRequest;

class UpdateCompanyRoleRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'companyId' => 'required|uuid',
            'roleId' => 'required|uuid',
            'roleName' => 'required|string',
        ];
    }

    public function authorize(): bool
    {
        return true;
    }

    protected function prepareForValidation(): void
    {
        $this->merge(['companyId' => $this->route('uuid')]);
        $this->merge(['roleId' => $this->route('uuid')]);
    }
}
