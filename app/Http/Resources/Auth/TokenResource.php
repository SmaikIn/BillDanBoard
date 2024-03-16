<?php

declare(strict_types=1);

namespace App\Http\Resources\Auth;

use App\Services\Auth\Dto\JWTDto;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TokenResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        /**
         * @var $token JWTDto
         */
        $token = $this;

        return [
            'accessToken' => $token->getToken(),
            'tokenType' => $token->getType(),
            'expires' => $token->getPayload()->getExpires()->toIso8601String(),
        ];
    }
}
