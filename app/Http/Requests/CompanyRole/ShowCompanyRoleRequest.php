<?php

namespace App\Http\Requests\CompanyRole;

use Illuminate\Foundation\Http\FormRequest;

class ShowCompanyRoleRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'companyId' => 'required|uuid',
            'roleId' => 'required|uuid',
        ];
    }

    public function authorize(): bool
    {
        return true;
    }

    protected function prepareForValidation(): void
    {
        $this->merge(['companyId' => $this->route('companyId')]);
        $this->merge(['roleId' => $this->route('role')]);
    }
}
