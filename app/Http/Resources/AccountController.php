<?php

namespace App\Http\Resources;

use App\Http\Controllers\Controller;
use App\Http\Requests\Account\CreateAccountRequest;
use App\Http\Requests\Account\UpdateAccountRequest;
use App\Http\Resources\User\UserResource;
use App\Http\Responses\JsonApiResponse;
use App\Http\Responses\JsonErrorResponse;
use App\Services\User\Dto\UserDto;
use App\Services\User\UserService;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Ramsey\Uuid\Uuid;

class AccountController extends Controller
{
    public function __construct(
        private readonly UserService $userService
    ) {
    }

    public function store(CreateAccountRequest $request)
    {
        $avatarPath = $this->getAvatarPath($request);

        $user = $this->userService->create($request->getDto($avatarPath));

        return $this->returnUserResource($user, $request);
    }

    public function update(UpdateAccountRequest $request, $uuid)
    {
        if (\Auth::id() != $uuid) {
            return new JsonErrorResponse(__('403'), status: Response::HTTP_FORBIDDEN);
        }

        $avatarPath = $this->getAvatarPath($request);

        $user = $this->userService->update($request->getDto($avatarPath));

        return $this->returnUserResource($user, $request);
    }

    public function destroy($uuid)
    {
        if (\Auth::id() != $uuid) {
            return new JsonErrorResponse(__('403'), status: Response::HTTP_FORBIDDEN);
        }

        $result = $this->userService->delete(Uuid::fromString($uuid));

        if ($result) {
            return new JsonApiResponse([]);
        }

        return new JsonErrorResponse('try Again');
    }

    private function getAvatarPath(Request $request): string
    {
        if ($request->hasFile('avatar')) {
            $avatarPath = $request->file('avatar')->store('avatars', 'public');
        } else {
            $avatarPath = 'avatar.svg';
        }

        return $avatarPath;
    }

    private function returnUserResource(UserDto $userDto, $request)
    {
        $userResource = new UserResource($userDto);

        return new JsonApiResponse($userResource->toArray($request));
    }
}
