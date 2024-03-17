<?php

namespace App\Listeners;

use App\Events\CreateUserEvent;
use App\Services\Mail\Dto\UserDto;
use App\Services\Mail\MailService;
use App\Services\User\UserService;

final readonly class CreateUserListener
{
    public function __construct(
        private UserService $userService,
        private MailService $mailService,
    ) {
    }

    public function handle(CreateUserEvent $event): void
    {
        $dbUser = $this->userService->find($event->getUserId());

        $user = new UserDto(
            id: $dbUser->getId(),
            firstName: $dbUser->getFirstName(),
            lastName: $dbUser->getLastName(),
            secondName: $dbUser->getSecondName(),
            email: $dbUser->getEmail(),
        );

        $user = $this->mailService->sendCreateAccount($user);
    }
}
