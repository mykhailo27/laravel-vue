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
            'size' => VariationModelController::getSizeFor($variant),
            'color' => VariationModelController::getColorFor($variant),
            'created_at' => $this->created_at,
        ];
    }
}
