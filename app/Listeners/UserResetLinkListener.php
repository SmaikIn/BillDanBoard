<?php

namespace App\Listeners;


use App\Http\Formater\Formater;
use App\Services\Mail\Dto\UserDto;
use App\Services\Mail\MailService;
use App\Services\User\Events\UserResetLinkEvent;
use Illuminate\Contracts\Queue\ShouldQueue;

final readonly class UserResetLinkListener implements ShouldQueue
{
    public function __construct(
        private MailService $mailService,
    ) {
    }

    public function handle(UserResetLinkEvent $event): void
    {
        $userDto = $event->getUserDto();
        $code = $event->getResetCode();

        $user = new UserDto(
            id: $userDto->getId(),
            firstName: $userDto->getFirstName(),
            lastName: $userDto->getLastName(),
            secondName: $userDto->getSecondName(),
            email: $userDto->getEmail(),
        );

        $this->mailService->sendResetLink($user, $code);
    }
}
