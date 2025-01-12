<?php

namespace App\Http\Resources;

use App\Dto\PermissionDto;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PermissionResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        /**
         * @var PermissionDto $this
         */
        $role = $this;

        return [
            'id' => $role->getId(),
            'name' => $role->getName(),
            'slug' => $role->getSlug(),
            'description' => $role->getDescription(),
        ];
    }
}
