<?php

declare(strict_types=1);

namespace App\Http\Resources\User;

use App\Dto\UserDto;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    public function toArray($request)
    {
        /**
         * @var UserDto $user
         */
        $user = $this;

        return [
            'id' => $user->getId()->toString(),
            'first_name' => $user->getFirstName(),
            'last_name' => $user->getLastName(),
            'second_name' => $user->getSecondName(),
            'email' => $user->getEmail()->value(),
            'phone' => is_null($user->getPhone()) ? null : $user->getPhone()->value(),
            'avatar' => $user->getPhoto()->getUrl(),
            'birthday' => is_null($user->getBirthday()) ? null : $user->getBirthday()->toString(),
            'created_at' => $user->getCreatedAt()->toString(),
        ];
    }
}
