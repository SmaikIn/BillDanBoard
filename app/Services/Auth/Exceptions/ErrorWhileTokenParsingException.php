<?php

namespace App\Services\Auth\Exceptions;

use RuntimeException;
use Throwable;

final class ErrorWhileTokenParsingException extends RuntimeException
{
    private ?Throwable $previousException;

    public function __construct(?Throwable $previousException = null)
    {
        $this->previousException = $previousException;

        parent::__construct('Error while parsing token');
    }

    public function getPreviousException(): string
    {
        return $this->previousException;
    }
}
