<?php

namespace App\Http\Controllers\Product;

use App\Constants\Ability;
use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

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
}
