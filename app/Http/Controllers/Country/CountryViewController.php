<?php

namespace App\Http\Controllers\Country;

use App\Constants\Ability;
use App\Http\Controllers\Controller;
use App\Http\Requests\Country\UpdateCountryRequest;
use App\Models\Country;
use App\Models\User;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;
use Inertia\Response;

class CountryViewController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): Response
    {
        $countries = Country::query()
            ->when($request->get('search'), static function (Builder $query, string $search) {
                $query->where('name', 'like', "%$search%")
                    ->orWhere('alpha_2', 'like', "%$search%");
            })
            ->paginate($request->get('per_page', 10))
            ->through(fn(Country $country) => [ // todo user resource
                'id' => $country->id,
                'name' => $country->name,
                'alpha_2' => $country->alpha_2,
                'alpha_3' => $country->alpha_3,
                'enabled' => $country->enabled,
                'zip_code_regex' => $country->zip_code_regex,
                'aliases' => $country->aliases,
                'created_at' => $country->created_at,
            ])
            ->withQueryString()
            ->onEachSide(0);

        return Inertia::render('Country/Index', [
            'countries' => $countries,
            'filters' => $request->only(['search']),
        ]);
    }

    /**
     * Update the specified resource in storage.
     * @throws AuthorizationException
     */
    public function update(UpdateCountryRequest $request, Country $country): RedirectResponse
    {
        $this->authorize(Ability::UPDATE, $country);

        return $country->update($request->validated())
            ? Redirect::route('countries.details', ['country' => $country->id])
                ->with('message', 'country-updated')
            : back()->withErrors(['error' => 'fail to update country']);
    }

    /**
     * Display the specified resource.
     */
    public function details(Country $country): Response
    {
        /** @var User $user */
        $user = Auth::user();

        return Inertia::render('Country/Details', [
            'country' => $country,
            'can' => [
                Ability::UPDATE => $user->can(Ability::UPDATE, $country)
            ]
        ]);
    }
}
