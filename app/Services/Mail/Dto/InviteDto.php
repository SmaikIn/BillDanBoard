<?php

namespace App\Services\Mail\Dto;

use App\Domain\ValueObjects\Email;
use Ramsey\Uuid\UuidInterface;

final readonly class InviteDto
{
    public function __construct(
        private string $userName,
        private UuidInterface $companyId,
        private string $companyName,
        private Email $emailInvite,
        private string $code,
    ) {
    }

    public function getCompanyName(): string
    {
        return $this->companyName;
    }

    public function getUserName(): string
    {
        return $this->userName;
    }

    public function getEmailInvite(): Email
    {
        return $this->emailInvite;
    }

    public function getCode(): string
    {
        return $this->code;
    }

    public function getCompanyId(): UuidInterface
    {
        return $this->companyId;
    }

}
