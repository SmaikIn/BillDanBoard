<?php

namespace App\Services\Mail;

use App\Services\Mail\Dto\CompanyDto;
use App\Services\Mail\Dto\InviteDto;
use App\Services\Mail\Dto\UserDto;

interface MailService
{
    public function sendCreateAccount(UserDto $userDto):void;

    public function sendCreateCompany(CompanyDto $companyDto, UserDto $userDto):void;

    public function sendInvite(InviteDto $inviteDto):void;
}