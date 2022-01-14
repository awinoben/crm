<?php

namespace App\Observers;

use App\Models\Industry;
use App\Models\KeyWord;
use Faker\Factory;

class IndustryObserver
{
    /**
     * Handle the Industry "created" event.
     *
     * @param Industry $industry
     * @return void
     */
    public function created(Industry $industry)
    {
        // create the keywords
        KeyWord::query()->create([
            'industry_id' => $industry->id,
            'key' => array(
                $industry->name
            )
        ]);
    }

    /**
     * Handle the Industry "updated" event.
     *
     * @param Industry $industry
     * @return void
     */
    public function updated(Industry $industry)
    {
        //
    }

    /**
     * Handle the Industry "deleted" event.
     *
     * @param Industry $industry
     * @return void
     */
    public function deleted(Industry $industry)
    {
        //
    }

    /**
     * Handle the Industry "restored" event.
     *
     * @param Industry $industry
     * @return void
     */
    public function restored(Industry $industry)
    {
        //
    }

    /**
     * Handle the Industry "force deleted" event.
     *
     * @param Industry $industry
     * @return void
     */
    public function forceDeleted(Industry $industry)
    {
        //
    }
}
