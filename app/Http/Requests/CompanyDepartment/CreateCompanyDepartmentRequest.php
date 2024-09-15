<?php

namespace App\Http\Requests\CompanyDepartment;

use Illuminate\Foundation\Http\FormRequest;

class CreateCompanyDepartmentRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'companyId' => 'required|uuid',
            'departmentName' => 'required|string',
        ];
    }

    public function authorize(): bool
    {
        return true;
    }

    protected function prepareForValidation(): void
    {
        $this->merge(['companyId' => $this->route('uuid')]);
    }
}
