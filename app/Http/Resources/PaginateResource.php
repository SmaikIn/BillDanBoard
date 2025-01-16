<?php

namespace App\Http\Resources;

use App\Dto\PaginationDto;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PaginateResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        /**
         * @var PaginationDto $this
         */
        $paginate = $this;

        return [
            $paginate->getResourceName()->value => $paginate->getItems(),
            'pagination' => [
                'total' => $paginate->getTotal(),
                'currentPage' => $paginate->getCurrentPage(),
                'lastPage' => $paginate->getLastPage(),
                'perPage' => $paginate->getPerPage(),
            ],

        ];
    }
}
