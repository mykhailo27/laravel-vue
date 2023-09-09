<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\Pivot;

/**
 * @property Variant $variant
 * @property Package $package
 */
class PackageVariant extends Pivot
{
    public function variant(): BelongsTo
    {
        return $this->belongsTo(Variant::class);
    }

    public function package(): BelongsTo
    {
        return $this->belongsTo(Package::class);
    }
}
