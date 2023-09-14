<?php

namespace App\Http\Controllers\Shipment;

use Illuminate\Auth\Access\AuthorizationException;
use App\Http\Resources\Variant\VariantResource;
use App\Http\Controllers\Controller;
use Illuminate\Http\Response;
use Illuminate\Http\Request;
use App\Constants\Ability;
use App\Models\Shipment;
use App\Models\Variant;

class ShipmentApiController extends Controller
{
    public function addVariant(Request $request, Shipment $shipment, Variant $variant): Response
    {
        $added = ShipmentModelController::addVariant($shipment, $variant, $request->quantity);
        $variant = ShipmentModelController::getVariantByShipment($shipment, $variant);

        return response([
            'message' => $added
                ? 'Variant has been added successful'
                : 'Fail to add variant to an shipment',
            'success' => $added,
            'variant' => new VariantResource($variant)
        ]);
    }

    public function removeVariant(Shipment $shipment, Variant $variant): Response
    {
        $removed = ShipmentModelController::removeVariant($shipment, $variant);

        return response([
            'message' => $removed
                ? 'Variant has been removed successful'
                : 'Fail to remove variant from a shipment',
            'success' => $removed,
            'variant' => new VariantResource($variant)
        ]);
    }

    public function deleteMultiple(Request $request): Response
    {
        try {
            $this->authorize(Ability::DELETE_ANY, Shipment::class);

            $ids = $request->get('ids');
            $deleted = ShipmentModelController::delete($ids);
            $success = $deleted === count($ids);

            return response([
                'success' => $success,
                'message' => $success ? 'All shipments deleted' : 'Some shipments deleted',
            ]);
        } catch (AuthorizationException $e) {
            return response([
                'success' => false,
                'message' => $e->getMessage(),
            ]);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function delete(Request $request): Response
    {
        try {
            $shipment = ShipmentModelController::getById($request->get('id'));

            $this->authorize(Ability::DELETE, $shipment);

            $deleted = ShipmentModelController::delete($shipment->id);
            return response([
                'success' => $deleted,
                'message' => $deleted ? 'Shipment deleted' : 'Shipment fail to be deleted',
            ]);
        } catch (AuthorizationException $e) {
            return response([
                'success' => false,
                'message' => $e->getMessage(),
            ]);
        }
    }
}
