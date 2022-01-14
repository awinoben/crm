<?php

namespace App\Observers;

use App\Models\Lead;
use App\Models\LeadStage;
use App\Models\Stage;

class LeadObserver
{
    /**
     * Handle the lead "created" event.
     *
     * @param Lead $lead
     * @return void
     */
    public function created(Lead $lead)
    {
        // create all lead stages
        foreach (Stage::all() as $stage) {
            LeadStage::query()->updateOrCreate([
                'lead_id' => $lead->id,
                'stage_id' => $stage->id,
                'level' => $stage->level
            ]);
        }
    }

    /**
     * Handle the lead "updated" event.
     *
     * @param Lead $lead
     * @return void
     */
    public function updated(Lead $lead)
    {
        //
    }

    /**
     * Handle the lead "deleted" event.
     *
     * @param Lead $lead
     * @return void
     */
    public function deleted(Lead $lead)
    {
        //
    }

    /**
     * Handle the lead "restored" event.
     *
     * @param Lead $lead
     * @return void
     */
    public function restored(Lead $lead)
    {
        //
    }

    /**
     * Handle the lead "force deleted" event.
     *
     * @param Lead $lead
     * @return void
     */
    public function forceDeleted(Lead $lead)
    {
        //
    }
}
