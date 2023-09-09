<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property int $in_transit
 * @property int $in_stock
 * @property Variant $variant
 * @property Closet $closet
 * @property int $variant_id
 */
class Inventory extends Model
{
    protected $fillable = ['in_stock', 'in_reserve', 'in_transit', 'variant_id', 'closet_id'];

    public function variant(): BelongsTo
    {
        return $this->belongsTo(Variant::class);
    }

    public function closet(): BelongsTo
    {
        return $this->belongsTo(Closet::class);
    }
}
