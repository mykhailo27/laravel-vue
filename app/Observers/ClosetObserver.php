<?php

namespace App\Observers;

use App\Models\Closet;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class ClosetObserver
{
    public function creating(Closet $closet): void
    {
        /** @var User $user */
        $user = Auth::user();
        $company = $user->selectedCompany();

        $closet->company_id = $company->id;
    }
    /**
     * Handle the Closet "created" event.
     */
    public function created(Closet $closet): void
    {
        //
    }

    /**
     * Handle the Closet "updated" event.
     */
    public function updated(Closet $closet): void
    {
        //
    }

    /**
     * Handle the Closet "deleted" event.
     */
    public function deleted(Closet $closet): void
    {
        //
    }

    /**
     * Handle the Closet "restored" event.
     */
    public function restored(Closet $closet): void
    {
        //
    }

    /**
     * Handle the Closet "force deleted" event.
     */
    public function forceDeleted(Closet $closet): void
    {
        //
    }
}
