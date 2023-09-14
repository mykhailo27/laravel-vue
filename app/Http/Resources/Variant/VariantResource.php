<?php

namespace App\Http\Resources\Variant;

use App\Http\Controllers\Variation\VariationModelController;
use App\Http\Controllers\Variant\VariantModelController;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Carbon;
use Illuminate\Http\Request;
use App\Models\Product;

/**
 * @property Product $product
 * @property Carbon $created_at
 */
class VariantResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $variant = VariantModelController::getById($this->id);

        return [
            'id' => $this->id,
            'name' => $variant->product->name,
            'price' => $variant->product->price,
            'sku' => $this->sku,
            'quantity' => $this->whenPivotLoaded('shipment_variant', function () {
                return $this->pivot->quantity;
            }),
            'in_stock' => $this->whenHas('in_stock', $this->in_stock),
            'in_reserve' => $this->whenHas('in_reserve', $this->in_reserve),
            'in_transit' => $this->whenHas('in_transit', $this->in_transit),
            'size' => VariationModelController::getSizeFor($variant),
            'color' => VariationModelController::getColorFor($variant),
            'created_at' => $this->created_at,
        ];
    }
}
