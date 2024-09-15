<?php

namespace App\Http\Requests\CompanyDepartment;

use Illuminate\Foundation\Http\FormRequest;

class UpdateCompanyDepartmentRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'companyId' => 'required|uuid',
            'departmentId' => 'required|uuid',
            'departmentName' => 'required|string',
        ];
    }

    public function authorize(): bool
    {
        return true;
    }

    protected function prepareForValidation(): void
    {
        $this->merge(['companyId' => $this->route('companyId')]);
        $this->merge(['departmentId' => $this->route('department')]);
    }
}
