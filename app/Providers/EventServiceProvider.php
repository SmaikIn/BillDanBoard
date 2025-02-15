<?php

namespace App\Providers;

use App\Listeners\CreateUserListener;
use App\Listeners\InviteUserToCompanyListener;
use App\Listeners\UserResetLinkListener;
use App\Services\Company\Events\InviteUserToCompanyEvent;
use App\Services\User\Events\CreateUserEvent;
use App\Services\User\Events\UserResetLinkEvent;
use App\Solutions\Yandex\YandexExtendSocialite;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use SocialiteProviders\Manager\SocialiteWasCalled;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event to listener mappings for the application.
     *
     * @var array<class-string, array<int, class-string>>
     */
    protected $listen = [
        Registered::class => [
            SendEmailVerificationNotification::class,
        ],
        SocialiteWasCalled::class => [
            YandexExtendSocialite::class.'@handle'
        ],
        CreateUserEvent::class => [
            CreateUserListener::class,
        ],
        InviteUserToCompanyEvent::class => [
            InviteUserToCompanyListener::class,
        ],
        UserResetLinkEvent::class => [
            UserResetLinkListener::class
        ],
    ];

    /**
     * Register any events for your application.
     */
    public function boot(): void
    {
        //
    }

    /**
     * Determine if events and listeners should be automatically discovered.
     */
    public function shouldDiscoverEvents(): bool
    {
        return false;
    }
}
