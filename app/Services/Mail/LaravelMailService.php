<?php

namespace App\Services\Mail;


use App\Mail\AccountRegisterMail;
use App\Mail\CreateCompanyMail;
use App\Services\Mail\Dto\CompanyDto;
use App\Services\Mail\Dto\UserDto;
use Illuminate\Support\Facades\Mail;

final class LaravelMailService implements MailService
{

    public function sendCreateAccount(UserDto $userDto): void
    {
        Mail::to($userDto->getEmail()->value())
            ->send(new AccountRegisterMail($userDto));
    }

    public function sendCreateCompany(CompanyDto $companyDto, UserDto $userDto): void
    {
        Mail::to($companyDto->getEmail()->value())
            ->cc($userDto->getEmail()->value())
            ->send(new CreateCompanyMail($userDto, $companyDto));
    }


}
