<?php

declare(strict_types=1);

namespace App\Dto;

use App\Enum\Resource;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Collection;

final readonly class PaginationDto
{
    public function __construct(
        private JsonResource $items,
        private Resource $resourceName,
        private int $total = 0,
        private int $currentPage = 1,
        private int $lastPage = 1,
    ) {
    }

    public function getItems(): JsonResource
    {
        return $this->items;
    }

    public function getTotal(): int
    {
        return $this->total;
    }

    public function getCurrentPage(): int
    {
        return $this->currentPage;
    }

    public function getLastPage(): int
    {
        return $this->lastPage;
    }

    public function getResourceName(): Resource
    {
        return $this->resourceName;
    }

}
