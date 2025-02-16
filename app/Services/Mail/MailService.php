<?php

namespace App\Services\Mail;


use App\Mail\AccountRegisterMail;
use App\Mail\CreateCompanyMail;
use App\Mail\InviteUserToCompanyMail;
use App\Mail\ResetPassword;
use App\Services\Mail\Dto\CompanyDto;
use App\Services\Mail\Dto\InviteDto;
use App\Services\Mail\Dto\UserDto;
use Illuminate\Support\Facades\Mail;

final class MailService
{

    public function sendCreateAccount(UserDto $userDto): void
    {
        Mail::to($userDto->getEmail()->value())
            ->send(new AccountRegisterMail($userDto));
    }

    public function sendResetLink(UserDto $userDto, $code): void
    {
        Mail::to($userDto->getEmail()->value())->send(new ResetPassword($userDto, $code));
    }

    public function sendCreateCompany(CompanyDto $companyDto, UserDto $userDto): void
    {
        Mail::to($companyDto->getEmail()->value())
            ->cc($userDto->getEmail()->value())
            ->send(new CreateCompanyMail($userDto, $companyDto));
    }

    public function sendInvite(InviteDto $inviteDto): void
    {
        Mail::to($inviteDto->getEmailInvite()->value())
            ->send(new InviteUserToCompanyMail($inviteDto));
    }


}
