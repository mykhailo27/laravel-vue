<?php

namespace App\Http\Controllers\StockMove;

use App\Constants\Ability;
use App\Enums\StockMoveType;
use App\Http\Controllers\Controller;
use App\Http\Resources\StockMove\StockMoveResource;
use App\Http\Resources\Variant\VariantResource;
use App\Models\StockMove;
use Illuminate\Database\Eloquent\Builder;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;
use Inertia\Response;

class StockMoveViewController extends Controller
{
    public function index(Request $request): Response
    {
        /** @var User $user */
        $user = Auth::user();

        $stock_moves = StockMove::query()
            ->when($request->get('search'), static function (Builder $query, string $search) {
                $query->where('type', 'like', "%$search%");
            })
            ->paginate($request->get('per_page', 10))
            ->through(fn($stock_move) => [ // todo user resource
                'id' => $stock_move->id,
                'type' => $stock_move->type->name,
                'created_at' => $stock_move->created_at,
                'can' => [
                    Ability::DELETE => $user->can(Ability::DELETE, $stock_move)
                ]
            ])
            ->withQueryString()
            ->onEachSide(0);

        return Inertia::render('StockMove/Index', [
            'stock_moves' => $stock_moves,
            'filters' => $request->only(['search']),
            'can' => [
                Ability::CREATE => $user->can(Ability::CREATE, StockMove::class),
                Ability::DELETE_ANY => $user->can(Ability::DELETE_ANY, StockMove::class)
            ]
        ]);
    }


    public function details(StockMove $stock_move): Response
    {
        return Inertia::render('StockMove/Details', [
            'stock_move' => new StockMoveResource($stock_move),
            'variant' => new VariantResource($stock_move->variant),
            'next_action' => StockMoveType::nextAction($stock_move->type),
            'previous_action' => StockMoveType::previousAction($stock_move->type)
        ]);
    }

}
