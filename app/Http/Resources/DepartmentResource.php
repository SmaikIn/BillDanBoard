<?php

namespace App\Http\Resources;

use App\Dto\DepartmentDto;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class DepartmentResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        /**
         * @var DepartmentDto $this
         */
        $department = $this;

        return [
            'id' => $department->getId(),
            'name' => $department->getName(),
            'companyId' => $department->getCompanyId(),
            'createdAt' => $department->getCreatedAt(),
        ];
    }
}
