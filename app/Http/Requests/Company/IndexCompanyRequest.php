<?php

namespace App\Http\Requests\Company;

use App\Domain\ValueObjects\Email;
use App\Domain\ValueObjects\Inn;
use App\Domain\ValueObjects\Kpp;
use App\Domain\ValueObjects\Phone;
use App\Services\Company\Dto\CreateCompanyDto;
use Illuminate\Foundation\Http\FormRequest;

class IndexCompanyRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'page' => [
                'int'
            ]
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}
