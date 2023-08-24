<?php

namespace App\Http\Controllers\Product;

use App\Constants\Ability;
use App\Enums\StockMoveType;
use App\Http\Controllers\Controller;
use App\Http\Controllers\StockMove\StockMoveModelController;
use App\Models\Product;
use App\Models\User;
use App\Models\Variant;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class ProductApiController extends Controller
{
    public function deleteMultiple(Request $request): Response
    {
        try {
            $this->authorize(Ability::DELETE_ANY, Product::class);

            $ids = $request->get('ids');
            $deleted = ProductModelController::delete($ids);
            $success = $deleted === count($ids);

            return response([
                'success' => $success,
                'message' => $success ? 'All products deleted' : 'Some products deleted',
            ]);
        } catch (AuthorizationException $e) {
            return response([
                'success' => false,
                'message' => $e->getMessage(),
            ]);
        }
    }

    public function delete(Request $request): Response
    {
        try {
            $product = ProductModelController::getById($request->get('id'));

            $this->authorize(Ability::DELETE, $product);

            $deleted = ProductModelController::delete($product->id);
            return response([
                'success' => $deleted,
                'message' => $deleted ? 'Product deleted' : 'Product fail to be deleted',
            ]);
        } catch (AuthorizationException $e) {
            return response([
                'success' => false,
                'message' => $e->getMessage(),
            ]);
        }
    }

    public function inventoryTransfer(Request $request): Response
    {
        $validated = $request->validate([
            'variant_id' => Rule::exists(Variant::class, 'id'),
            'amount' => 'integer|min:1'
        ]);

        /** @var User $user */
        $user = Auth::user();
        $company = $user->selectedCompany();
        $closet = $company->generalCloset();

        $attributes = array_merge($validated, [
            'company_id' => $company->id,
            'warehouse_id' => $closet->warehouse_id,
            'type' => StockMoveType::REQUESTED
        ]);

        $created = !is_null(StockMoveModelController::create($attributes));

        return response([
            'success' => $created,
            'message' => $created ? 'Stock move created' : 'Fail to create stock move',
        ]);
    }
}
