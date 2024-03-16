<?php

namespace App\Domain\ValueObjects;

use InvalidArgumentException;

final class Photo
{
    /** @var string */
    private string $url;
    private string $name;
    private bool $isMain;

    private function __construct(string $url, string $name, bool $isMain)
    {
        if (!filter_var($url, FILTER_VALIDATE_URL)) {
            throw new InvalidArgumentException(
                'Photo url '.$url.' is not valid');
        }

        $this->url = $url;
        $this->name = $name;
        $this->isMain = $isMain;
    }

    public static function create(string $url, string $name, bool $isMain = false): Photo
    {
        return new Photo($url, $name, $isMain);
    }

    public function getUrl(): string
    {
        return $this->url;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function isMain(): bool
    {
        return $this->isMain;
    }

    public function toArray(): array
    {
        return [
            'url' => $this->getUrl(),
            'name' => $this->getName(),
            'isMain' => $this->isMain(),
        ];
    }
}
