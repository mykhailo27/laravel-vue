<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphTo;

/**
 * @method static create(array $attributes)
 * @method static find(string $id)
 * @property Country $country
 */
class Address extends Model
{
    use HasFactory, HasUuids;

    protected $fillable = ['line_1', 'line_2', 'zip_code', 'city', 'state_or_region', 'country_id', 'addressable_id', 'addressable_type'];

    public function addressable(): MorphTo
    {
        return $this->morphTo();
    }

    public function country(): BelongsTo
    {
        return $this->belongsTo(Country::class);
    }
}
