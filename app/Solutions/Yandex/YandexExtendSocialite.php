<?php

declare(strict_types=1);


namespace App\Solutions\Yandex;

use SocialiteProviders\Manager\SocialiteWasCalled;

class YandexExtendSocialite
{
    public function handle(SocialiteWasCalled $socialiteWasCalled): void
    {
        $socialiteWasCalled->extendSocialite('yandex', Provider::class);
    }
}