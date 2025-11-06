<?php

namespace App\Providers;

use App\Events\CommissionAdjusted;
use App\Events\CommissionAdjustUpdated;
use App\Events\CommissionDeleted;
use App\Events\CommissionPasswordVerified;
use App\Events\CommissionStatusUpdated;
use App\Events\CommissionUpdated;
use App\Events\FileExported;
use App\Events\FileImported;
use App\Events\OrderSync;
use App\Events\PermissionCreated;
use App\Events\PermissionDeleted;
use App\Events\PermissionUpdated;
use App\Events\RecordDeleted;
use App\Events\RoleCreated;
use App\Events\RoleDeleted;
use App\Events\RolePermissionsUpdated;
use App\Events\RoleUpdated;
use App\Events\UserCreated;
use App\Events\UserLoggedIn;
use App\Events\UserUpdated;
use App\Listeners\LogCommissionAdjust;
use App\Listeners\LogCommissionAdjustUpdate;
use App\Listeners\LogCommissionDelete;
use App\Listeners\LogCommissionPasswordVerify;
use App\Listeners\LogCommissionStatusUpdate;
use App\Listeners\LogCommissionUpdate;
use App\Listeners\LogFileExport;
use App\Listeners\LogFileImport;
use App\Listeners\LogOrderSync;
use App\Listeners\LogPermissionCreate;
use App\Listeners\LogPermissionDelete;
use App\Listeners\LogPermissionUpdate;
use App\Listeners\LogRecordDelete;
use App\Listeners\LogRoleCreate;
use App\Listeners\LogRoleDelete;
use App\Listeners\LogRolePermissionsUpdate;
use App\Listeners\LogRoleUpdate;
use App\Listeners\LogUserCreate;
use App\Listeners\LogUserLoggedIn;
use App\Listeners\LogUserUpdate;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Event;

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
        FileImported::class => [
            LogFileImport::class
        ],
        FileExported::class => [
            LogFileExport::class
        ],
        OrderSync::class => [
            LogOrderSync::class
        ],
        CommissionStatusUpdated::class => [
            LogCommissionStatusUpdate::class
        ],
        CommissionPasswordVerified::class => [
            LogCommissionPasswordVerify::class
        ],
        CommissionAdjusted::class => [
            LogCommissionAdjust::class
        ],
        CommissionAdjustUpdated::class => [
            LogCommissionAdjustUpdate::class
        ],
        CommissionUpdated::class => [
            LogCommissionUpdate::class
        ],
        CommissionDeleted::class => [
            LogCommissionDelete::class
        ],
        RecordDeleted::class => [
            LogRecordDelete::class
        ],
        RoleCreated::class => [
            LogRoleCreate::class
        ],
        RoleUpdated::class => [
            LogRoleUpdate::class
        ],
        RoleDeleted::class => [
            LogRoleDelete::class
        ],
        RolePermissionsUpdated::class => [
            LogRolePermissionsUpdate::class
        ],
        PermissionCreated::class => [
            LogPermissionCreate::class
        ],
        PermissionUpdated::class => [
            LogPermissionUpdate::class
        ],
        PermissionDeleted::class => [
            LogPermissionDelete::class
        ],
        UserLoggedIn::class => [
            LogUserLoggedIn::class
        ],
        UserCreated::class => [
            LogUserCreate::class
        ],
        UserUpdated::class => [
            LogUserUpdate::class
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
