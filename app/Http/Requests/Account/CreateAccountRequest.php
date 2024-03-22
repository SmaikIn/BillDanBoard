<?php

namespace App\Http\Requests\Account;

use App\Domain\ValueObjects\Email;
use App\Domain\ValueObjects\Password;
use App\Domain\ValueObjects\Phone;
use App\Services\User\Dto\CreateUserDto;
use Illuminate\Foundation\Http\FormRequest;

class CreateAccountRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'firstName' => 'required|string|max:255',
            'lastName' => 'required|string|max:255',
            'secondName' => 'nullable|string|max:255',
            'email' => 'required|email|unique:users,email',
            'phone' => 'nullable|string|max:20',
            'avatar' => 'file',
            'birthday' => 'nullable|date',
            'password' => 'required|string|min:6',
            'yandexId' => 'nullable|string',
        ];
    }

    public function authorize(): bool
    {
        return true;
    }

    public function getDto(string $avatarPath): CreateUserDto
    {
        return new CreateUserDto(
            firstName: $this->get('firstName'),
            lastName: $this->get('lastName'),
            secondName: $this->get('secondName'),
            phone: is_null($this->get('phone')) ? null : Phone::create($this->get('phone')),
            password: Password::create($this->get('password')),
            photo: $avatarPath,
            email: Email::create($this->get('email')),
            yandexId: $this->get('yandexId'),
            birthday: $this->get('birthday'),
        );
    }
}
