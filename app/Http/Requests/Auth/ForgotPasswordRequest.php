<?php

declare(strict_types=1);

namespace App\Http\Requests\Auth;

use Illuminate\Foundation\Http\FormRequest;

class ForgotPasswordRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'token' => 'required|string',
            'password' => [
                'required',
                'string',
            ]
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}
