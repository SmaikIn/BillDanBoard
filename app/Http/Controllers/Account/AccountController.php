<?php

namespace App\Http\Controllers\Account;

use App\Http\Controllers\Controller;
use App\Http\Requests\Account\CreateAccountRequest;
use App\Http\Resources\User\UserResource;
use App\Http\Responses\JsonApiResponse;
use App\Services\User\UserService;
use Illuminate\Http\Request;

class AccountController extends Controller
{
    public function __construct(
        private readonly UserService $userService
    ) {
    }

    public function store(CreateAccountRequest $request)
    {
        if ($request->hasFile('avatar')) {
            $avatarPath = $request->file('avatar')->store('avatars', 'public');
        } else {
            $avatarPath = 'avatar.svg';
        }

        $user = $this->userService->create($request->getDto($avatarPath));

        $userResource = new UserResource($user);

        return new JsonApiResponse($userResource->toArray($request));
    }

    public function show($id)
    {
    }

    public function update(Request $request, $id)
    {
    }

    public function destroy($id)
    {
    }
}
