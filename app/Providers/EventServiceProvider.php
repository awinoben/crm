<?php

namespace App\Providers;

use App\Events\GlobalEvent;
use App\Listeners\GlobalListener;
use App\Models\Company;
use App\Models\Industry;
use App\Models\Lead;
use App\Observers\CompanyObserver;
use App\Observers\IndustryObserver;
use App\Observers\LeadObserver;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        Registered::class => [
            SendEmailVerificationNotification::class,
        ],
        GlobalEvent::class => [
            GlobalListener::class,
        ],
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        Lead::observe(LeadObserver::class);
        Industry::observe(IndustryObserver::class);
        Company::observe(CompanyObserver::class);
    }
}
