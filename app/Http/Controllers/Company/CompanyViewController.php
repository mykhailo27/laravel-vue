<?php

namespace App\Http\Controllers\Company;

use App\Constants\Ability;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreCompanyRequest;
use App\Http\Requests\UpdateCompanyRequest;
use App\Models\Company;
use App\Models\User;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;
use Inertia\Response;

class CompanyViewController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): Response
    {
        /** @var User $user */
        $user = Auth::user();

        $companies = Company::query()
            ->when($request->get('search'), static function (Builder $query, string $search) {
                $query->where('name', 'like', "%$search%")
                    ->orWhere('abbreviation', 'like', "%$search%");
            })
            ->paginate($request->get('per_page', 10))
            ->through(fn($company) => [ // todo user resource
                'id' => $company->id,
                'name' => $company->name,
                'abbreviation' => $company->abbreviation,
                'logo' => $company->logo,
                'created_at' => $company->created_at,
                'can' => [
                    Ability::DELETE => $user->can(Ability::DELETE, $company)
                ]
            ])
            ->withQueryString()
            ->onEachSide(0);

        return Inertia::render('Company/Index', [
            'companies' => $companies,
            'filters' => $request->only(['search']),
            'can' => [
                Ability::CREATE => $user->can(Ability::CREATE, Company::class),
                Ability::DELETE_ANY => $user->can(Ability::DELETE_ANY, Company::class)
            ]
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function details(Company $company): Response
    {
        return Inertia::render('Company/Details', [
            'company' => $company,
            'company_users' => $company->users,
            'non_company_users' => CompanyModelController::nonCompanyUser($company)
        ]);
    }

    /**
     * Store a newly created resource in storage.
     * @throws AuthorizationException
     */
    public function store(StoreCompanyRequest $request): RedirectResponse
    {
        $this->authorize(Ability::CREATE, Company::class);

        $company = Company::create($request->validated());

        return Redirect::route('companies.details', [
            'company' => $company->id
        ])->with('message', 'company-created');
    }

    /**
     * Show the form for creating a new resource.
     * @throws AuthorizationException
     */
    public function create(): Response
    {
        $this->authorize(Ability::CREATE, Company::class);

        return Inertia::render('Company/Details', [
            'company' => null,
            'company_users' => null,
            'non_company_users' => null,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCompanyRequest $request, Company $company): RedirectResponse
    {
        $company->update($request->validated());

        return Redirect::route('companies.details', [
            'company' => $company->id
        ])->with('message', 'company-updated');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Company $company): RedirectResponse
    {
        $company->delete();

        return Redirect::route('companies.index')
            ->with('message', "$company->name is deleted");
    }
}
