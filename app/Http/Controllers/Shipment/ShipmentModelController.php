<?php

namespace App\Http\Controllers\Shipment;

use App\Http\Controllers\Controller;
use App\Models\Shipment;
use App\Models\Variant;

class ShipmentModelController extends Controller
{
    public static function delete(mixed $ids): int
    {
        return Shipment::destroy($ids);
    }

    public static function getById(string $id): ?Shipment
    {
        return Shipment::find($id);
    }

    public static function addVariant(Shipment $shipment, Variant $variant, int $quantity): bool
    {
        $shipment->variants()->syncWithoutDetaching([
            $variant->id => ['quantity' => $quantity]
        ]);

        return self::hasVariant($shipment, $variant);
    }

    private static function hasVariant(Shipment $shipment, Variant $variant): bool
    {
        return $shipment->variants()
            ->wherePivot('variant_id', '=', $variant->id)
            ->exists();
    }

    public static function removeVariant(Shipment $shipment, Variant $variant): int
    {
        return $shipment->variants()
            ->detach($variant->id);
    }

    public static function getVariantByShipment(Shipment $shipment, Variant $variant): ?Variant
    {
        return $shipment->variants()
            ->where('id', '=', $variant->id)
            ->first();
    }
}
