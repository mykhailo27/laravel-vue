<?php

namespace App\Http\Controllers\Warehouse;

use App\Constants\Ability;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Country\CountryModelController;
use App\Http\Requests\Warehouse\StoreWarehouseRequest;
use App\Http\Requests\Warehouse\UpdateWarehouseRequest;
use App\Models\User;
use App\Models\Warehouse;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;
use Inertia\Response;

class WarehouseViewController extends Controller
{
    public function index(Request $request): Response
    {
        /** @var User $user */
        $user = Auth::user();

        $warehouses = Warehouse::query()
            ->when($request->get('search'), static function (Builder $query, string $search) {
                $query->where('name', 'like', "%$search%");
            })
            ->paginate($request->get('per_page', 10))
            ->through(fn(Warehouse $warehouse) => [ // todo user resource
                'id' => $warehouse->id,
                'name' => $warehouse->name,
                'return_cost' => $warehouse->return_cost . ' ' . $warehouse->currency,
                'created_at' => $warehouse->created_at,
                'responsible_user' => $warehouse->responsibleUser->name,
                'can' => [
                    Ability::DELETE => $user->can(Ability::DELETE, $warehouse)
                ]
            ])
            ->withQueryString()
            ->onEachSide(0);

        return Inertia::render('Warehouse/Index', [
            'warehouses' => $warehouses,
            'filters' => $request->only(['search']),
            'can' => [
                Ability::CREATE => $user->can(Ability::CREATE, Warehouse::class),
                Ability::DELETE_ANY => $user->can(Ability::DELETE_ANY, Warehouse::class)
            ]
        ]);
    }

    public function details(Warehouse $warehouse): Response
    {
        $address = $warehouse->address;

        return Inertia::render('Warehouse/Details', [
            'warehouse' => $warehouse,
            'address' => $address,
            'country' => $address?->country,
            'countries' => CountryModelController::getAll(),
            'users' => User::all(),
            'none_active_countries' => WarehouseModelController::noneActiveCountries($warehouse),
            'active_countries' => $warehouse->countries,
            'responsible_user' => $warehouse->responsibleUser,
        ]);
    }

    /**
     * @throws AuthorizationException
     */
    public function store(StoreWarehouseRequest $request): RedirectResponse
    {
        $warehouse = Warehouse::create($request->validated());

        return Redirect::route('warehouses.details', [
            'warehouse' => $warehouse->id
        ])->with('message', 'warehouse-created');
    }

    /**
     * @throws AuthorizationException
     */
    public function create(): Response
    {
        $this->authorize(Ability::CREATE, Warehouse::class);
        $countries = CountryModelController::getAll();

        return Inertia::render('Warehouse/Details', [
            'warehouse' => null,
            'address' => null,
            'country' => null,
            'countries' => $countries,
            'users' => User::all(),
            'none_active_countries' => $countries,
            'active_countries' => [],
            'responsible_user' => null,
        ]);
    }

    public function destroy(Warehouse $warehouse): RedirectResponse
    {
        $warehouse->delete();

        return Redirect::route('roles.index')
            ->with('message', "$warehouse->name is deleted");
    }

    public function update(UpdateWarehouseRequest $request, Warehouse $warehouse): RedirectResponse
    {
        $warehouse->update($request->validated());

        return Redirect::route('warehouses.details', [
            'warehouse' => $warehouse->id
        ])->with('message', 'warehouse-updated');
    }
}
