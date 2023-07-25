<?php

namespace App\Http\Controllers\Warehouse;

use App\Http\Controllers\Controller;
use App\Models\Country;
use App\Models\Warehouse;
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
}
