<?php

namespace App\Http\Controllers\StockMove;

use App\Constants\Ability;
use App\Enums\StockMoveType;
use App\Events\StockMoveProcessed;
use App\Http\Controllers\Controller;
use App\Http\Resources\StockMove\StockMoveResource;
use App\Models\StockMove;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Event;

class StockMoveApiController extends Controller
{
    public function delete(Request $request): Response
    {
        try {
            $stock_move = StockMoveModelController::getById($request->get('id'));

            $this->authorize(Ability::DELETE, $stock_move);

            $deleted = StockMoveModelController::delete($stock_move->id);
            return response([
                'success' => $deleted,
                'message' => $deleted ? 'Stock move deleted' : 'Stock move fail to be deleted',
            ]);
        } catch (AuthorizationException $e) {
            return response([
                'success' => false,
                'message' => $e->getMessage(),
            ]);
        }
    }

    public function deleteMultiple(Request $request): Response
    {
        try {
            $this->authorize(Ability::DELETE_ANY, StockMove::class);

            $ids = $request->get('ids');
            $deleted = StockMoveModelController::delete($ids);
            $success = $deleted === count($ids);

            return response([
                'success' => $success,
                'message' => $success ? 'All stock-moves deleted' : 'Some stock-moves deleted',
            ]);
        } catch (AuthorizationException $e) {
            return response([
                'success' => false,
                'message' => $e->getMessage(),
            ]);
        }
    }

    public function process(StockMove $stock_move, string $action): Response
    {
        $processed = StockMoveModelController::update($stock_move, [
            'type' => StockMoveType::getByAction($action)
        ]);

        if ($stock_move->type === StockMoveType::PROCESSED) {
            StockMoveProcessed::dispatch($stock_move);
        }

        return response([
            'stock_move' => new StockMoveResource($stock_move),
            'next_action' => StockMoveType::nextAction($stock_move->type),
            'previous_action' => StockMoveType::previousAction($stock_move->type),
            'success' => $processed,
            'message' => $processed ? 'Stock move processed' : 'Stock move failed to be processed',
        ]);
    }
}
