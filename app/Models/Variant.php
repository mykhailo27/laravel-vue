<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @property Product $product
 */
class Variant extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = ['sku', 'product_id'];

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    public function variations(): HasMany
    {
        return $this->hasMany(Variation::class);
    }

    public function inventories(): HasMany
    {
        return $this->hasMany(Inventory::class);
    }

    public function packages(): BelongsToMany
    {
        return $this->belongsToMany(Package::class)
            ->using(PackageVariant::class)
            ->withPivot('quantity')
            ->withTimestamps();
    }

    public function shipments(): BelongsToMany
    {
        return $this->belongsToMany(Shipment::class)
            ->using(ShipmentVariant::class)
            ->withPivot('quantity')
            ->withTimestamps();
    }
}
