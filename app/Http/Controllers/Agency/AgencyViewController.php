<?php

namespace App\Http\Controllers\Agency;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreAgencyRequest;
use App\Http\Requests\UpdateAgencyRequest;
use App\Models\Agency;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;
use Inertia\Response;

class AgencyViewController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): Response
    {
        $agencies = Agency::paginate(5)->through(static function ($agency) {
            return [
                'id' => $agency->id,
                'name' => $agency->name,
                'email' => $agency->email,
                'created_at' => $agency->created_at,
            ];
        });

        return Inertia::render('Agency/Index', [
            'agencies' => $agencies
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreAgencyRequest $request): RedirectResponse
    {
        $agency = Agency::create([
            'name' => $request->name,
            'email' => $request->email,
        ]);

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
            'agency' => null
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function details(Agency $agency): Response
    {
        return Inertia::render('Agency/Details', [
            'agency' => $agency
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
