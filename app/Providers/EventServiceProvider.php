<?php

namespace App\Providers;

use App\Events\InventoryStockUpdate;
use App\Events\StockMoveProcessed;
use App\Listeners\SelectCompanyListener;
use App\Listeners\ProcessInventory;
use App\Listeners\UpdatePackageStateOnInventoryStockUpdate;
use App\Models\Closet;
use App\Models\Company;
use App\Models\Inventory;
use App\Models\PackageVariant;
use App\Models\Product;
use App\Observers\ClosetObserver;
use App\Observers\CompanyObserver;
use App\Observers\InventoryObserver;
use App\Observers\PackageVariantObserver;
use App\Observers\ProductObserver;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Events\PasswordReset;
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
        PasswordReset::class => [
            SelectCompanyListener::class
        ],
        StockMoveProcessed::class => [
            ProcessInventory::class
        ],
        InventoryStockUpdate::class => [
            UpdatePackageStateOnInventoryStockUpdate::class
        ]
    ];

    /**
     * The model observers for your application.
     *
     * @var array
     */
    protected $observers = [
        Company::class => [CompanyObserver::class],
        Closet::class => [ClosetObserver::class],
        Product::class => [ProductObserver::class],
        Inventory::class => [InventoryObserver::class],
        PackageVariant::class => [PackageVariantObserver::class]
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
