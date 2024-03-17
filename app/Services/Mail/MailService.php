<?php

namespace App\Services\Mail;

use App\Services\Mail\Dto\Order\OrderShowDto;
use App\Services\Mail\Dto\UserDto;

interface MailService
{

    public function sendCreateAccount(UserDto $userDto);

}