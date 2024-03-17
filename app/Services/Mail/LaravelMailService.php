<?php

namespace App\Services\Mail;


use App\Domain\ValueObjects\Email;
use App\Mail\AccountRegisterMail;
use App\Mail\OrderCreatedForManagersMail;
use App\Mail\OrderCreatedForUserMail;
use App\Mail\RegisterNewUser;
use App\Services\Mail\Dto\CityDto;
use App\Services\Mail\Dto\CompanyDto;
use App\Services\Mail\Dto\Order\OrderShowDto;
use App\Services\Mail\Dto\UserDto;
use Illuminate\Support\Facades\Mail;

final class LaravelMailService implements MailService
{
    public function __construct()
    {
    }


    public function sendCreateAccount(UserDto $userDto)
    {
        Mail::to(config('mail.orders'))
            ->cc($userDto->getEmail()->value())
            ->send(new AccountRegisterMail($userDto));
    }

    /**
     * @param  UserDto  $userDto
     * @param  OrderShowDto  $orderDto
     * @param  string[]  $managers
     * @return void
     */
    public function sendOrderToManagers(UserDto $userDto, OrderShowDto $orderDto, array $managers): void
    {
        $emailsForSend = array_merge($managers, config('mail.admin_emails'));

        Mail::to(config('mail.orders'))
            ->cc($emailsForSend)
            ->send(new OrderCreatedForManagersMail($userDto, $orderDto));
    }

    public function sendOrderToUser(UserDto $userDto, OrderShowDto $orderDto): void
    {
        Mail::to($userDto->getEmail()->value())->send(new OrderCreatedForUserMail($userDto, $orderDto));
    }

    public function sendUserRegisteredToManagers(
        UserDto $userDto,
        CityDto $cityDto,
        CompanyDto $companyDto = null
    ): void {
        if ($userDto->isEntity()) {
            Mail::to(config('mail.emails.managers.to'))
                ->cc(config('mail.emails.managers.cc'))
                ->send(new RegisterNewUser($userDto, $cityDto, $companyDto));
        } else {
            Mail::to(config('mail.emails.managers.to'))
                ->cc(config('mail.emails.managers.cc'))
                ->send(new RegisterNewUser($userDto, $cityDto, null));
        }
    }
}
