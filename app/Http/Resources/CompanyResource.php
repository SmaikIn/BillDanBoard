<?php

namespace App\Http\Resources;

use App\Services\Company\Dto\CompanyDto;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CompanyResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        /**
         * @var CompanyDto $this
         */
        $company = $this;

        return [
            'uuid' => $company->getUuid(),
            'name' => $company->getName(),
            'inn' => $company->getInn()->value(),
            'kpp' => is_null($company->getKpp()) ? null : $company->getKpp()->value(),
            'email' => $company->getEmail()->value(),
            'phone' => $company->getPhone()->value(),
            'url' => $company->getUrl(),
            'description' => $company->getDescription(),
            'isActive' => $company->isActive(),

        ];
    }
}
