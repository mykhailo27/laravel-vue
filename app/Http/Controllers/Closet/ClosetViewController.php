<?php

namespace App\Http\Controllers\Closet;

use App\Constants\Ability;
use App\Http\Controllers\Controller;
use App\Http\Requests\Closet\StoreClosetRequest;
use App\Http\Requests\Closet\UpdateClosetRequest;
use App\Models\Closet;
use App\Models\User;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;
use Inertia\Response;

class ClosetViewController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): Response
    {
        /** @var User $user */
        $user = Auth::user();

        $closets = Closet::query()
            ->when($request->get('search'), static function (Builder $query, string $search) {
                $query->where('name', 'like', "%$search%");
            })
            ->paginate($request->get('per_page', 10))
            ->through(fn($closet) => [ // todo user resource
                'id' => $closet->id,
                'name' => $closet->name,
                'active' => $closet->active,
                'created_at' => $closet->created_at,
                'can' => [
                    Ability::DELETE => $user->can(Ability::DELETE, $closet)
                ]
            ])
            ->withQueryString()
            ->onEachSide(0);

        return Inertia::render('Closet/Index', [
            'closets' => $closets,
            'filters' => $request->only(['search']),
            'can' => [
                Ability::CREATE => $user->can(Ability::CREATE, Closet::class),
                Ability::DELETE_ANY => $user->can(Ability::DELETE_ANY, Closet::class)
            ]
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function details(Closet $closet): Response
    {
        return Inertia::render('Closet/Details', [
            'closet' => $closet,
            'closet_users' => $closet->users,
            'non_closet_users' => ClosetModelController::nonClosetUser($closet),
        ]);
    }

    /**
     * @throws AuthorizationException
     */
    public function create(): Response
    {
        $this->authorize(Ability::CREATE, Closet::class);

        return Inertia::render('Closet/Details', [
            'closet' => null,
            'closet_users' => null,
            'non_closet_users' => null,
        ]);
    }

    /**
     * @throws AuthorizationException
     */
    public function store(StoreClosetRequest $request): RedirectResponse
    {
        $this->authorize(Ability::CREATE, Closet::class);

        return is_null($closet = Closet::create($request->validated()))
            ? back()->withErrors(['error' => 'fail to create closet'])
            : Redirect::route('closets.details', ['closet' => $closet->id])->with('message', 'closet created');
    }

    /**
     * @throws AuthorizationException
     */
    public function update(UpdateClosetRequest $request, Closet $closet): RedirectResponse
    {
        $this->authorize(Ability::UPDATE, $closet);

        return $closet->update($request->validated())
            ? Redirect::route('closets.details', ['closet' => $closet->id])
                ->with('message', 'closet-updated')
            : back()->withErrors(['error' => 'fail to update closet']);
    }
}
