<?php

namespace App\Http\Controllers\Shipment;

use App\Http\Controllers\Country\CountryModelController;
use App\Http\Controllers\Variant\VariantModelController;
use App\Http\Requests\Shipment\StoreShipmentRequest;
use App\Http\Requests\Shipment\UpdateShipmentRequest;
use App\Http\Resources\Variant\VariantCollection;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Constants\Ability;
use App\Models\Shipment;
use Inertia\Response;
use App\Models\User;
use Inertia\Inertia;

class ShipmentViewController extends Controller
{
    public function index(Request $request): Response
    {
        /** @var User $user */
        $user = Auth::user();

        $shipments = Shipment::query()
            ->when($request->get('search'), static function (Builder $query, string $search) {
                $query->where('recipient_name', 'like', "%$search%")
                    ->orWhere('recipient_email', 'like', "%$search%")
                    ->orWhere('recipient_email', 'like', "%$search%")
                    ->orWhere('state', 'like', "%$search%");
            })
            ->paginate($request->get('per_page', 10))
            ->through(fn(Shipment $shipment) => [ // todo user resource
                'id' => $shipment->id,
                'recipient_name' => $shipment->recipient_name,
                'recipient_email' => $shipment->recipient_email,
                'recipient_phone' => $shipment->recipient_phone,
                'supplier_name' => $shipment->supplier->name,
                'state' => $shipment->state,
                'created_at' => $shipment->created_at,
                'can' => [
                    Ability::DELETE => $user->can(Ability::DELETE, $shipment)
                ]
            ])
            ->withQueryString()
            ->onEachSide(0);

        return Inertia::render('Shipment/Index', [
            'shipments' => $shipments,
            'filters' => $request->only(['search']),
            'can' => [
                Ability::CREATE => $user->can(Ability::CREATE, Shipment::class),
                Ability::DELETE_ANY => $user->can(Ability::DELETE_ANY, Shipment::class)
            ]
        ]);
    }

    /**
     * Show the form for creating a new resource.
     * @throws AuthorizationException
     */
    public function create(): Response
    {
        $this->authorize(Ability::CREATE, Shipment::class);
        /** @var User $user */
        $user = Auth::user();
        $none_shipment_variants = VariantModelController::getVariantsInCloset($user->currentCloset());

        return Inertia::render('Shipment/Details', [
            'shipment' => null,
            'address' => null,
            'country' => null,
            'countries' => CountryModelController::getAll(),
            'shipment_variants' => null,
            'none_shipment_variants' => new VariantCollection($none_shipment_variants)
        ]);
    }

    /**
     * Store a newly created resource in storage.
     * @throws AuthorizationException
     */
    public function store(StoreShipmentRequest $request): RedirectResponse
    {
        $this->authorize(Ability::CREATE, Shipment::class);

        /** @var User $user */
        $user = $request->user();
        if (is_null($closet = $user->currentCloset())) {
            return back()->withErrors(['error' => 'No current closet']);
        }

        $validated = $request->validated();
        $validated['closet_id'] = $closet->id;

        return is_null($company = Shipment::create($validated))
            ? back()->withErrors(['error' => 'fail to create shipment'])
            : Redirect::route('shipments.details', ['shipment' => $company->id])->with('message', 'shipment created');
    }

    /**
     * Display the specified resource.
     */
    public function details(Shipment $shipment): Response
    {
        $address = $shipment->address;
        $none_shipment_variants = VariantModelController::getVariantsInClosetNotInShipment($shipment);

        return Inertia::render('Shipment/Details', [
            'shipment' => $shipment,
            'address' => $address,
            'country' => $address?->country,
            'countries' => CountryModelController::getAll(),
            'shipment_variants' => new VariantCollection($shipment->variants),
            'none_shipment_variants' => new VariantCollection($none_shipment_variants)
        ]);
    }

    /**
     * Update the specified resource in storage.
     * @throws AuthorizationException
     */
    public function update(UpdateShipmentRequest $request, Shipment $shipment): RedirectResponse
    {
        $this->authorize(Ability::UPDATE, $shipment);

        $validated = $request->validated();

        return $shipment->update($validated)
            ? Redirect::route('shipments.details', ['shipment' => $shipment->id])->with('message', 'shipment-updated')
            : back()->withErrors(['error' => 'fail to update shipment']);
    }
}
