<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\Pivot;

/**
 * @property Variant $variant
 * @property Shipment $shipment
 */

class ShipmentVariant extends Pivot
{
    public function shipment(): BelongsTo
    {
        return $this->belongsTo(Shipment::class);
    }

    public function variant(): BelongsTo
    {
        return $this->belongsTo(Variant::class);
    }
}
