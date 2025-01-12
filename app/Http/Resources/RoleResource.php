<?php

namespace App\Http\Resources;

use App\Dto\RoleDto;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class RoleResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        /**
         * @var RoleDto $this
         */
        $role = $this;

        return [
            'id' => $role->getId(),
            'name' => $role->getName(),
            'companyId' => $role->getCompanyId(),
            'createdAt' => $role->getCreatedAt(),
        ];
    }
}
