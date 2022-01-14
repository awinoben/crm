<?php

namespace App\Listeners;

use App\Events\GlobalEvent;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;

class GlobalListener
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param GlobalEvent $event
     * @return void
     */
    public function handle(GlobalEvent $event)
    {
        if (Schema::hasColumn($event->model->getTable(), 'slug')) {
            $event->model->slug = Str::slug($event->model->name);
        }

        if (Schema::hasColumn($event->model->getTable(), 'company_id')) {
            if (request()->user())
                $event->model->company_id = request()->user()->company_id;
        }
    }
}
