<?php

namespace App\Http\Controllers\Auth;

use App\Domain\ValueObjects\Email;
use App\Domain\ValueObjects\Password;
use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Resources\Auth\TokenResource;
use App\Http\Resources\User\UserResource;
use App\Http\Responses\JsonApiResponse;
use App\Http\Responses\JsonErrorResponse;
use App\Services\Auth\AuthService;
use App\Services\Auth\Dto\AuthAttemptDto;
use App\Services\Auth\Dto\JWTDto;
use App\Services\User\UserService;
use Illuminate\Http\Request;
use InvalidArgumentException;

class AuthController extends Controller
{
    public function __construct(
        private readonly AuthService $authService,
        private readonly UserService $userService,
    ) {
    }

    public function login(LoginRequest $request): JsonApiResponse|JsonErrorResponse
    {
        try {
            $dto = new AuthAttemptDto(
                Email::create($request->get('email')),
                Password::create($request->get('password'))
            );
        } catch (InvalidArgumentException) {
            return new JsonErrorResponse(__('auth.failed'));
        }

        $token = $this->authService->attempt($dto);

        if (is_null($token)) {
            return new JsonErrorResponse(__('auth.failed'));
        }

        return $this->respondWithToken($token);
    }

    public function me(Request $request)
    {
        $payload = $this->authService->getPayloadFromToken($request->bearerToken());

        $user = $this->userService->find($payload->getUserId());

        $userResource = new UserResource($user);

        return new JsonApiResponse($userResource->toArray($request));
    }

    public function logout()
    {
        $this->authService->logout();

        return new JsonApiResponse([], status: 204);
    }

    public function refresh()
    {
        $token = $this->authService->refresh();

        if (is_null($token)) {
            return new JsonErrorResponse(__('auth.refresh'));
        }

        return $this->respondWithToken($token);
    }

    protected function respondWithToken(JWTDto $token): JsonApiResponse
    {
        $userResource = new UserResource($this->userService->find($token->getPayload()->getUserId()));
        $tokenResource = new TokenResource($token);

        $responseData = array_merge($tokenResource->toArray(request()), ['user' => $userResource->toArray(request())]);

        return new JsonApiResponse($responseData);
    }
}
