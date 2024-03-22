<?php

namespace App\Http\Requests\Account;

use App\Domain\ValueObjects\Email;
use App\Domain\ValueObjects\Phone;
use App\Services\User\Dto\UpdateUserDto;
use Illuminate\Foundation\Http\FormRequest;
use Ramsey\Uuid\Uuid;

class UpdateAccountRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'uuid' => 'required|uuid',
            'firstName' => 'required|string|max:255',
            'lastName' => 'required|string|max:255',
            'secondName' => 'nullable|string|max:255',
            'email' => 'required|email|unique:users,email',
            'phone' => 'nullable|string|max:20',
            'avatar' => 'file',
            'birthday' => 'nullable|date',
            'yandexId' => 'nullable|string',
        ];
    }

    public function authorize(): bool
    {
        return true;
    }

    protected function prepareForValidation(): void
    {
        $this->merge(['uuid' => $this->route('uuid')]);
    }

    public function getDto(string $avatarPath): UpdateUserDto
    {
        return new UpdateUserDto(
            id: Uuid::fromString($this->input('uuid')),
            firstName: $this->get('firstName'),
            lastName: $this->get('lastName'),
            secondName: $this->get('secondName'),
            phone: is_null($this->get('phone')) ? null : Phone::create($this->get('phone')),
            photo: $avatarPath,
            email: Email::create($this->get('email')),
            birthday: $this->get('birthday'),
        );
    }
}
