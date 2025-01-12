<?php

namespace App\Services\Company\Events;

use App\Domain\ValueObjects\Email;
use Illuminate\Foundation\Events\Dispatchable;
use Ramsey\Uuid\UuidInterface;

class InviteUserToCompanyEvent
{
    use Dispatchable;

    /**
     * @param  UuidInterface  $companyId
     * @param  UuidInterface  $userId
     * @param  Email  $email
     * @param  string  $code
     */
    public function __construct(
        private readonly UuidInterface $companyId,
        private readonly UuidInterface $userId,
        private readonly Email $email,
        private readonly string $code,
    ) {
    }

    public function getCompanyId(): UuidInterface
    {
        return $this->companyId;
    }

    public function getUserId(): UuidInterface
    {
        return $this->userId;
    }

    public function getEmail(): Email
    {
        return $this->email;
    }

    public function getCode(): string
    {
        return $this->code;
    }
}
