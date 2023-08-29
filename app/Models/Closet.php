<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @method static create(array $attributes)
 * @property Warehouse $warehouse
 * @property string $warehouse_id
 */
class Closet extends Model
{
    use HasFactory, HasUuids, SoftDeletes;

    protected $fillable = ['name', 'active', 'warehouse_id'];

    public function company(): BelongsTo
    {
        return $this->belongsTo(Company::class);
    }

    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class)
            ->using(ClosetUser::class)
            ->withPivot('active')
            ->withTimestamps();
    }

    public function inventories(): HasMany
    {
        return $this->hasMany(Inventory::class);
    }

    public function warehouse(): BelongsTo
    {
        return $this->belongsTo(Warehouse::class);
    }
}
