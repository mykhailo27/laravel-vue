<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Inventory extends Model
{
    protected $fillable = ['quantity', 'type'];

    public function variant(): BelongsTo
    {
        return $this->belongsTo(Variant::class);
    }

    public function closet(): BelongsTo
    {
        return $this->belongsTo(Closet::class);
    }
}
