<?php

namespace App\Http\Controllers\Variant;

use App\Constants\Ability;
use App\Http\Controllers\Controller;
use App\Models\Variant;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class VariantApiController extends Controller
{
    public function deleteMultiple(Request $request): Response
    {
        try {
            $this->authorize(Ability::DELETE_ANY, Variant::class);

            $ids = $request->get('ids');
            $deleted =  VariantModelController::delete($ids);
            $success = $deleted === count($ids);

            return response([
                'success' => $success,
                'message' => $success ? 'All variants deleted' : 'Some variants deleted',
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
            $variant = VariantModelController::getById($request->get('id'));

            $this->authorize(Ability::DELETE, $variant);

            $deleted = VariantModelController::delete($variant->id);
            return response([
                'success' => $deleted,
                'message' => $deleted ? 'Variant deleted' : 'Variant fail to be deleted',
            ]);
        } catch (AuthorizationException $e) {
            return response([
                'success' => false,
                'message' => $e->getMessage(),
            ]);
        }
    }
}
