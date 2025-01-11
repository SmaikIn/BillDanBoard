<?php

namespace App\Listeners;

use App\Services\Company\CompanyService;
use App\Services\Company\Events\InviteUserToCompanyEvent;
use App\Services\Mail\Dto\InviteDto;
use App\Services\Mail\MailService;
use App\Services\User\UserService;
use Illuminate\Contracts\Queue\ShouldQueue;

class InviteUserToCompanyListener implements ShouldQueue
{

    public function __construct(
        private UserService $userService,
        private CompanyService $companyService,
        private MailService $mailService,
    ) {
    }

    public function handle(InviteUserToCompanyEvent $event): void
    {
        $company = $this->companyService->find($event->getCompanyId());
        $user = $this->userService->find($event->getUserId());

        $email = $event->getEmail();
        $code = $event->getCode();

        $dto = new InviteDto(
            $user->getFirstName().' '.$user->getLastName(),
            $company->getUuid(),
            $company->getName(),
            $email,
            $code
        );


        $this->mailService->sendInvite($dto);
    }
}
