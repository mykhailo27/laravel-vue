<?php

namespace App\Http\Controllers\Package;

use App\Http\Controllers\Variant\VariantModelController;
use App\Http\Requests\Package\UpdatePackageRequest;
use App\Http\Requests\Package\StorePackageRequest;
use App\Http\Resources\Variant\VariantCollection;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Redirect;
use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Constants\Ability;
use App\Models\Package;
use Inertia\Response;
use App\Models\User;
use Inertia\Inertia;

class PackageViewController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): Response
    {
        /** @var User $user */
        $user = Auth::user();
        $closet = $user->currentCloset();

        $packages = Package::query()
            ->when($request->get('search'), static function (Builder $query, string $search) {
                $query->where('name', 'like', "%$search%");
            })->where('closet_id', '=', $closet->id)
            ->paginate($request->get('per_page', 10))
            ->through(fn($package) => [
                'id' => $package->id,
                'name' => $package->name,
                'desc' => $package->desc,
                'state' => $package->state,
                'created_at' => $package->created_at,
                'can' => [
                    Ability::DELETE => $user->can(Ability::DELETE, $package)
                ]
            ])
            ->withQueryString()
            ->onEachSide(0);

        return Inertia::render('Package/Index', [
            'packages' => $packages,
            'filters' => $request->only(['search']),
            'can' => [
                Ability::CREATE => $user->can(Ability::CREATE, Package::class),
                Ability::DELETE_ANY => $user->can(Ability::DELETE_ANY, Package::class)
            ]
        ]);
    }

    /**
     * Show the form for creating a new resource.
     * @throws AuthorizationException
     */
    public function create(): Response
    {
        $this->authorize(Ability::CREATE, Package::class);

        return Inertia::render('Package/Details', [
            'package' => null,
            'package_variants' => null,
            'non_package_variants' => new VariantCollection(VariantModelController::getAll()),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     * @throws AuthorizationException
     */
    public function store(StorePackageRequest $request): RedirectResponse
    {
        $this->authorize(Ability::CREATE, Package::class);

        return is_null($package = Package::create($request->validated()))
            ? back()->withErrors(['error' => 'fail to create package'])
            : Redirect::route('packages.details', ['package' => $package->id])->with('message', 'package created');
    }

    public function details(Package $package): Response
    {
        /** @var User $user */
        $user = Auth::user();
        $closet = $user->currentCloset();

        return Inertia::render('Package/Details', [
            'package' => $package,
            'package_variants' => new VariantCollection($package->variants),
            'non_package_variants' => new VariantCollection(PackageModelController::getVariantsInClosetNotInPackage($closet, $package)),
        ]);
    }

    /**
     * Update the specified resource in storage.
     * @throws AuthorizationException
     */
    public function update(UpdatePackageRequest $request, Package $package): RedirectResponse
    {
        $this->authorize(Ability::UPDATE, $package);

        return $package->update($request->validated())
            ? Redirect::route('packages.details', ['package' => $package->id])
                ->with('message', 'package-updated')
            : back()->withErrors(['error' => 'fail to update package']);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Package $package): RedirectResponse
    {
        $package->delete();

        return Redirect::route('packages.index')
            ->with('message', "$package->name is deleted");
    }
}
