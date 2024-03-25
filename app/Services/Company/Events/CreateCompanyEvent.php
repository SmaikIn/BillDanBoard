<?php

namespace App\Services\Company\Events;

use Illuminate\Foundation\Events\Dispatchable;
use Ramsey\Uuid\UuidInterface;

class CreateCompanyEvent
{
    use Dispatchable;

    public function __construct(
        private readonly UuidInterface $companyId,
    ) {
    }

    public function getCompanyId(): UuidInterface
    {
        return $this->companyId;
    }
}
