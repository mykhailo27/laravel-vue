<?php

namespace App\Models;

use App\Enums\StockMoveType;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @property Variant $variant
 * @property StockMoveType $type
 * @property int $amount
 * @method static create(array $attributes)
 */
class StockMove extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = ['type', 'amount', 'variant_id', 'closet_id', 'warehouse_id'];

    protected $casts = [
        'type' => StockMoveType::class
    ];

    public function closet(): BelongsTo
    {
        return $this->belongsTo(Closet::class);
    }

    public function warehouse(): BelongsTo
    {
        return $this->belongsTo(Warehouse::class);
    }

    public function variant(): BelongsTo
    {
        return $this->belongsTo(Variant::class);
    }
}
