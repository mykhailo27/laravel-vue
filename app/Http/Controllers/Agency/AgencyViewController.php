<?php

namespace App\Http\Controllers\Agency;

use App\Http\Controllers\Controller;
use App\Http\Requests\Agency\StoreAgencyRequest;
use App\Http\Requests\Agency\UpdateAgencyRequest;
use App\Models\Agency;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;
use Inertia\Response;

class AgencyViewController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): Response
    {
        $search = $request->get('search');
        $per_page = $request->get('per_page', 10);

        $agencies = Agency::where(static function ($query) use ($search) {
            $query->where('name', 'LIKE', '%' . $search . '%')
                ->orWhere('email', 'LIKE', '%' . $search . '%');
        })
            ->paginate($per_page)
            ->withQueryString()
            ->onEachSide(0);


        return Inertia::render('Agency/Index', [
            'agencies' => $agencies
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreAgencyRequest $request): RedirectResponse
    {
        $agency = Agency::create($request->validated());

        return Redirect::route('agencies.details', [
            'agency' => $agency->id
        ])->with('message', 'agency-created');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): Response
    {
        return Inertia::render('Agency/Details', [
            'agency' => null,
            'agency_users' => null,
            'non_agency_users' => null,
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function details(Agency $agency): Response
    {
        return Inertia::render('Agency/Details', [
            'agency' => $agency,
            'agency_users' => $agency->users,
            'non_agency_users' => $agency->nonAgencyUser()
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateAgencyRequest $request, Agency $agency): RedirectResponse
    {
        $agency->update($request->validated());

        return Redirect::route('agencies.details', [
            'agency' => $agency->id
        ])->with('message', 'agency-updated');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Agency $agency): RedirectResponse
    {
        $agency->delete();

        return Redirect::route('agencies.index')
            ->with('message', "$agency->name is deleted");
    }
}
