<?php

namespace App\Services\Mail;

use App\Services\Mail\Dto\CompanyDto;
use App\Services\Mail\Dto\UserDto;

interface MailService
{
    public function sendCreateAccount(UserDto $userDto);

    public function sendCreateCompany(CompanyDto $companyDto, UserDto $userDto);
}