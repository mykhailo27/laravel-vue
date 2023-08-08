<?php

namespace App\Observers;

use App\Http\Controllers\Company\CompanyModelController;
use App\Models\Company;

class CompanyObserver
{

    public function creating(Company $company): void
    {
        CompanyModelController::assignOwnerAndAgency($company);
    }

    /**
     * Handle the Company "created" event.
     */
    public function created(Company $company): void
    {
        //
    }

    /**
     * Handle the Company "updated" event.
     */
    public function updated(Company $company): void
    {
        //
    }

    /**
     * Handle the Company "deleted" event.
     */
    public function deleted(Company $company): void
    {
        //
    }

    /**
     * Handle the Company "restored" event.
     */
    public function restored(Company $company): void
    {
        //
    }

    /**
     * Handle the Company "force deleted" event.
     */
    public function forceDeleted(Company $company): void
    {
        //
    }
}
