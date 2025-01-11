<?php

namespace App\Listeners;

use App\Services\Company\CompanyService;
use App\Services\Company\Events\CreateCompanyEvent;
use App\Services\Mail\Dto\CompanyDto;
use App\Services\Mail\Dto\UserDto;
use App\Services\Mail\MailService;
use App\Services\User\UserService;
use Illuminate\Contracts\Queue\ShouldQueue;

class CreateCompanyListener implements ShouldQueue
{
    public function __construct(
        private UserService $userService,
        private CompanyService $companyService,
        private MailService $mailService,
    ) {
    }

    public function handle(CreateCompanyEvent $event): void
    {
        $dbCompany = $this->companyService->find($event->getCompanyId());

        $company = new CompanyDto(
            name: $dbCompany->getName(),
            inn: $dbCompany->getInn(),
            kpp: $dbCompany->getKpp(),
            email: $dbCompany->getEmail(),
            phone: $dbCompany->getPhone(),
            url: $dbCompany->getUrl(),
            description: $dbCompany->getDescription(),
        );

        $dbUser = $this->userService->firstUserInCompany($event->getCompanyId());

        $user = new UserDto(
            id: $dbUser->getId(),
            firstName: $dbUser->getFirstName(),
            lastName: $dbUser->getLastName(),
            secondName: $dbUser->getSecondName(),
            email: $dbUser->getEmail(),
        );

        $this->mailService->sendCreateCompany($company, $user);
    }
}
