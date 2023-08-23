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
 */
class StockMove extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = ['type'];

    protected $casts = [
        'type' => StockMoveType::class
    ];

    public function company(): BelongsTo
    {
        return $this->belongsTo(Company::class);
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
