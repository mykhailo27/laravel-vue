<?php

namespace App\Models;

use App\Enums\InventoryType;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property InventoryType $type
 */
class Inventory extends Model
{
    protected $casts = [
        'type' => InventoryType::class
    ];

    protected $fillable = ['quantity', 'type', 'variant_id', 'closet_id'];

    public function variant(): BelongsTo
    {
        return $this->belongsTo(Variant::class);
    }

    public function closet(): BelongsTo
    {
        return $this->belongsTo(Closet::class);
    }
}
