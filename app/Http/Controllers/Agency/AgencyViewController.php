<?php

namespace App\Http\Controllers\Agency;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreAgencyRequest;
use App\Http\Requests\UpdateAgencyRequest;
use App\Http\Resources\Agency\AgencyResource;
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
        return Inertia::render('Agency/Index', [
            'agencies' => Agency::all()
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

        return Redirect::route('agency.edit', [
            'agency' => $agency->id
        ])->with('message', 'agency-created');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): Response
    {
        return Inertia::render('Agency/Create');
    }

    /**
     * Display the specified resource.
     */
    public function show(Agency $agency): Response
    {
        return Inertia::render('Agency/Show', [
            'agency' => new AgencyResource($agency)
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Agency $agency): Response
    {
        return Inertia::render('Agency/Edit', [
            'agency' => new AgencyResource($agency)
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateAgencyRequest $request, Agency $agency): RedirectResponse
    {
        $agency->update($request->validated());

        return Redirect::route('agency.edit')
            ->with('message', 'agency-updated');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Agency $agency): RedirectResponse
    {
        $agency->delete();

        return Redirect::route('agency.index')
            ->with('message', "$agency->name is deleted");
    }
}
