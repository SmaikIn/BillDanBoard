<?php

declare(strict_types=1);

namespace App\Services\Auth;

use App\Services\Auth\Dto\AuthAttemptDto;
use App\Services\Auth\Dto\JWTDto;
use App\Services\Auth\Dto\PayloadJWTDto;
use App\Services\Auth\Exceptions\ErrorWhileTokenParsingException;
use Carbon\Carbon;
use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;
use Throwable;
use Tymon\JWTAuth\JWTGuard;

final readonly class LaravelAuthService implements AuthService
{
    public function __construct(
        private JWTGuard $guard,
    ) {
    }

    public function getPayloadFromToken(string $token): PayloadJWTDto
    {
        return $this->parsePayloadFromToken($token);
    }

    public function attempt(AuthAttemptDto $dto): ?JWTDto
    {
        $token = $this->guard->attempt([
            'email' => $dto->getEmail()->value(),
            'password' => $dto->getPassword()->value()
        ]);

        if (!$token) {
            return null;
        }

        return $this->getJWTDtoFromToken($token);
    }

    public function logout(): void
    {
        $this->guard->logout();
    }

    public function refresh(): ?JWTDto
    {
        try {
            $token = $this->guard->refresh();
        } catch (Throwable) {
            return null;
        }

        return $this->getJWTDtoFromToken($token);
    }

    /**
     * @param  string  $token
     * @return JWTDto
     * @throws ErrorWhileTokenParsingException
     */
    private function getJWTDtoFromToken(string $token): JWTDto
    {
        $payload = $this->parsePayloadFromToken($token);

        return new JWTDto(
            $token,
            'bearer',
            $payload,
        );
    }

    /**
     * @param  string  $token
     * @return PayloadJWTDto
     * @throws ErrorWhileTokenParsingException
     */
    private function parsePayloadFromToken(string $token): PayloadJWTDto
    {
        try {
            $payload = json_decode(base64_decode(explode('.', $token)[1]));
        } catch (Throwable $throwable) {
            throw new ErrorWhileTokenParsingException($throwable);
        }

        return new PayloadJWTDto(
            userId: Uuid::fromString($payload->sub),
            expires: Carbon::parse($payload->exp),
        );
    }
}