<?php

namespace App\Providers;

use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Event;
use App\Events\JobDataInsertion;
use App\Listeners\DataInsertedSuccess;
use App\Listeners\DataInsertedFailed;
use Laravel\Passport\Events\AccessTokenCreated;
use App\Listeners\StoreTokenInDatabase;
use Illuminate\Auth\Events\Login;
use Illuminate\Auth\Events\Logout;
use Illuminate\Auth\Events\PasswordReset;
use App\Listeners\LogUserLoginAndLogout;
use App\Listeners\LogUserPasswordChange;
use App\Events\CsvProcessingCompleted;
use App\Events\CsvProcessingFailed;
use App\Listeners\SendCsvProcessingNotification;
use App\Events\DispatchQrUploadBySerial;
use App\Listeners\HandleDispatchQrUploadBySerial;
use App\Events\QrUploadRequested;
use App\Listeners\HandleQrUploadRequested;


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
        JobDataInsertion::class => [
            DataInsertedSuccess::class,
            DataInsertedFailed::class,
        ],
        Login::class => [
            LogUserLoginAndLogout::class . '@handleLogin',
        ],
        Logout::class => [
            LogUserLoginAndLogout::class . '@handleLogout',
        ],
        PasswordReset::class => [
            LogUserPasswordChange::class,
        ],
        CsvProcessingCompleted::class => [
            SendCsvProcessingNotification::class,
        ],
        CsvProcessingFailed::class => [
            SendCsvProcessingNotification::class,
        ],
        DispatchQrUploadBySerial::class => [
            HandleDispatchQrUploadBySerial::class,
        ],
        QrUploadRequested::class => [
            HandleQrUploadRequested::class,
        ],
        // AccessTokenCreated::class => [
        //     StoreTokenInDatabase::class,
        // ],
        
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
