<?php

namespace App\Http\Requests\Auth;

use App\Domain\ValueObjects\Email;
use App\Domain\ValueObjects\Inn;
use App\Domain\ValueObjects\Ip;
use App\Domain\ValueObjects\Kpp;
use App\Domain\ValueObjects\Password;
use App\Domain\ValueObjects\Phone;
use App\Services\User\Dto\StoreUserCompanyDto;
use App\Services\User\Dto\UserRegisterDto;
use Illuminate\Foundation\Http\FormRequest;

class RegisterUserRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'email' => 'required|string|email|max:255',
            'firstName' => 'required|string|max:255',
            'lastName' => 'required|string|max:255',
            'password' => 'required|string|min:8',
            'phone' => 'required|string|max:30',
            'cityId' => 'required|int',
            'inn' => 'string|between:10,12',
            'companyName' => 'required_with:inn|string|max:255',
            'kpp' => 'nullable|string|size:9',
            'stockCityId' => 'nullable|int',
            'withNds' => 'required_with:inn|bool'
        ];
    }

    public function getUserRegisterDto(): UserRegisterDto
    {
        return new UserRegisterDto(
            email: Email::create($this->get('email')),
            firstName: $this->get('firstName'),
            lastName: $this->get('lastName'),
            password: Password::create($this->get('password')),
            phone: Phone::create($this->get('phone')),
            cityId: $this->get('cityId'),
            ip: Ip::create(ip()),
            stockCityId: $this->get('stockCityId'),
        );
    }

    public function getCompanyDto(): ?StoreUserCompanyDto
    {
        return new StoreUserCompanyDto(
            inn: Inn::create($this->get('inn')),
            kpp: $this->get('kpp') ? Kpp::create($this->get('kpp')) : null,
            withNds: $this->get('withNds'),
            companyName: $this->get('companyName'),
        );
    }
}
