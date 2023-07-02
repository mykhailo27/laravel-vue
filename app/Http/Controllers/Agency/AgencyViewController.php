<?php

namespace App\Http\Controllers\Agency;

use App\Constants\Ability;
use App\Http\Controllers\Controller;
use App\Http\Requests\Agency\StoreAgencyRequest;
use App\Http\Requests\Agency\UpdateAgencyRequest;
use App\Models\Agency;
use App\Models\User;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
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
        /** @var User $user */
        $user = Auth::user();

        $agencies = Agency::query()
            ->when($request->get('search'), static function (Builder $query, string $search) {
                $query->where('name', 'like', "%$search%")
                    ->orWhere('email', 'like', "%$search%");
            })
            ->paginate($request->get('per_page', 10))
            ->through(fn($agency) => [
                'id' => $agency->id,
                'name' => $agency->name,
                'email' => $agency->email,
                'created_at' => $agency->created_at,
                'can' => [
                    Ability::DELETE => $user->can(Ability::DELETE, $agency)
                ]
            ])
            ->withQueryString()
            ->onEachSide(0);

        return Inertia::render('Agency/Index', [
            'agencies' => $agencies,
            'filters' => $request->only(['search']),
            'can' => [
                Ability::CREATE => $user->can(Ability::CREATE, Agency::class),
                Ability::DELETE_ANY => $user->can(Ability::DELETE_ANY, Agency::class)
            ]
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreAgencyRequest $request): RedirectResponse
    {
        return !is_null($agency = Agency::create($request->validated()))
            ? Redirect::route('agencies.details', ['agency' => $agency->id])
                ->with('message', 'agency-created')
            : back()->withErrors(['error' => 'fail to store agency']);
    }

    /**
     * Show the form for creating a new resource.
     * @throws AuthorizationException
     */
    public function create(): Response
    {
        $this->authorize(Ability::CREATE, Agency::class);

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
            'non_agency_users' => AgencyModelController::nonAgencyUser($agency)
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateAgencyRequest $request, Agency $agency): RedirectResponse
    {
        return $agency->update($request->validated())
            ? Redirect::route('agencies.details', ['agency' => $agency->id])
                ->with('message', 'agency-updated')
            : back()->withErrors(['error' => 'fail to update agency']);
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
