<?php

namespace App\Http\Resources\Variant;

use App\Http\Controllers\Variant\VariantModelController;
use App\Http\Controllers\Variation\VariationModelController;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

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
            'sku' => $this->sku,
            'in_stock' => $this->whenHas('in_stock', $this->in_stock),
            'in_reserve' => $this->whenHas('in_reserve', $this->in_reserve),
            'in_transit' => $this->whenHas('in_transit', $this->in_transit),
            'size' => VariationModelController::getSizeFor($variant),
            'color' => VariationModelController::getColorFor($variant),
            'created_at' => $this->created_at,
        ];
    }
}
