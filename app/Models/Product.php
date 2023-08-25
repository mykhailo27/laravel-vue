<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @method static create(array $attributes)
 */
class Product extends Model
{
    use HasFactory, HasUuids, SoftDeletes;

    protected $fillable = ['name', 'desc', 'sku', 'price'];

    public function variants(): HasMany
    {
        return $this->hasMany(Variant::class);
    }
}
