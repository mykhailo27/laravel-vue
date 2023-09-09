<?php

namespace App\Models;

use App\Enums\PackageState;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @property Collection $variants
 * @property Closet $closet
 * @property PackageState $state
 */
class Package extends Model
{
    use HasFactory, SoftDeletes, HasUuids;

    protected $fillable = ['name', 'desc', 'closet_id'];

    protected $casts = [
        'state' => PackageState::class
    ];

    public function closet(): BelongsTo
    {
        return $this->belongsTo(Closet::class);
    }

    public function variants(): BelongsToMany
    {
        return $this->belongsToMany(Variant::class)
            ->using(PackageVariant::class)
            ->withPivot('quantity')
            ->withTimestamps();
    }
}
