<?php

namespace App\Http\Resources\StockMove;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class StockMoveResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'type' => $this->type->name,
            'created_at' => $this->created_at,
        ];
    }
}
