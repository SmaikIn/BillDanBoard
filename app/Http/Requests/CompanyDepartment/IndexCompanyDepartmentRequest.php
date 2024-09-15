<?php

namespace App\Http\Requests\CompanyDepartment;

use Illuminate\Foundation\Http\FormRequest;

class IndexCompanyDepartmentRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'companyId' => 'required|uuid',
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
