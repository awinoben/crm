<?php

namespace App\Observers;

use App\Models\Company;
use App\Models\Product;

class CompanyObserver
{
    /**
     * Handle the Company "created" event.
     *
     * @param Company $company
     * @return void
     */
    public function created(Company $company)
    {
        Product::query()->create([
            'company_id' => $company->id,
            'key' => array(
                $company->industry->name
            )
        ]);
    }

    /**
     * Handle the Company "updated" event.
     *
     * @param Company $company
     * @return void
     */
    public function updated(Company $company)
    {
        //
    }

    /**
     * Handle the Company "deleted" event.
     *
     * @param Company $company
     * @return void
     */
    public function deleted(Company $company)
    {
        //
    }

    /**
     * Handle the Company "restored" event.
     *
     * @param Company $company
     * @return void
     */
    public function restored(Company $company)
    {
        //
    }

    /**
     * Handle the Company "force deleted" event.
     *
     * @param Company $company
     * @return void
     */
    public function forceDeleted(Company $company)
    {
        //
    }
}
