<?php

namespace App\Http\Controllers\Warehouse;

use App\Constants\Ability;
use App\Http\Controllers\Controller;
use App\Models\Country;
use App\Models\Warehouse;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class WarehouseApiController extends Controller
{
    public function addCountry(Warehouse $warehouse, Country $country): Response
    {
        $added = WarehouseModelController::addCountry($warehouse, $country);

        return response([
            'message' => $added
                ? 'Country has been added successful'
                : 'Fail to add country to an warehouse',
            'success' => $added,
            'country' => WarehouseModelController::getCountry($warehouse, $country)
        ]);
    }

    public function removeCountry(Warehouse $warehouse, Country $country): Response
    {
        $removed = WarehouseModelController::removeCountry($warehouse, $country);

        return response([
            'message' => $removed
                ? 'Country has been removed successful'
                : 'Fail to remove country from an company',
            'success' => $removed,
            'country' => $country
        ]);
    }

    public function delete(Request $request): Response
    {
        try {
            $warehouse = WarehouseModelController::getById($request->get('id'));

            $this->authorize(Ability::DELETE, $warehouse);

            $deleted = WarehouseModelController::delete($warehouse->id);
            return response([
                'success' => $deleted,
                'message' => $deleted ? 'Warehouse deleted' : 'Warehouse fail to be deleted',
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
            $this->authorize(Ability::DELETE_ANY, Warehouse::class);

            $ids = $request->get('ids');
            $deleted = WarehouseModelController::delete($ids);
            $success = $deleted === count($ids);

            return response([
                'success' => $success,
                'message' => $success ? 'All warehouses deleted' : 'Some warehouses deleted',
            ]);
        } catch (AuthorizationException $e) {
            return response([
                'success' => false,
                'message' => $e->getMessage(),
            ]);
        }
    }
}
