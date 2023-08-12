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

        return array_merge(parent::share($request), [
            'auth' => [
                'user' => $user,
            ],
            'selected_company' => $user->selectedCompany(['company_id as id', 'name']),
            'user_companies' => $user->companies()->wherePivot('selected', '=', false)->get(['company_id as id', 'name']),
            'user_closets' => [ // todo get the current user closets
                ['name' => 'general', 'id' => '998b712f-0a53-4f21-ae85-fd68b6ce8a23', 'selected' => true],
                ['name' => 'sunday', 'id' => '998b712f-0b5c-453d-a12b-0533c8073ff4',  'selected' => false],
            ],
            'ziggy' => function () use ($request) {
                return array_merge((new Ziggy)->toArray(), [
                    'location' => $request->url(),
                ]);
            },
        ]);
    }
}
