<?php

namespace App\Http\Middleware;

use App\Models\User;
use Illuminate\Http\Request;
use Inertia\Middleware;
use Tightenco\Ziggy\Ziggy;

class HandleInertiaRequests extends Middleware
{
    /**
     * The root template that is loaded on the first page visit.
     *
     * @var string
     */
    protected $rootView = 'app';

    /**
     * Determine the current asset version.
     */
    public function version(Request $request): string|null
    {
        return parent::version($request);
    }

    /**
     * Define the props that are shared by default.
     *
     * @return array<string, mixed>
     */
    public function share(Request $request): array
    {
        /** @var User $user */
        $user = $request->user();
        $selected_company = $user?->selectedCompany(['company_id as id', 'name']);

        return array_merge(parent::share($request), [
            'auth' => [
                'user' => $user,
            ],
            'selected_company' => $selected_company,
            'user_companies' => $user?->companies()->wherePivot('selected', '=', false)->get(['company_id as id', 'name']),
            'selected_closet' => $user?->selectedCloset($selected_company, ['closet_id as id', 'name']),
            'user_closets' => $user?->closets()->wherePivot('active', '=', false)->where('closets.company_id', '=', $selected_company->id)
                ->get(['closet_id as id', 'name']),
            'ziggy' => function () use ($request) {
                return array_merge((new Ziggy)->toArray(), [
                    'location' => $request->url(),
                ]);
            },
        ]);
    }
}
