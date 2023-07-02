<?php

namespace App\Models;

use App\Enums\CompanyState;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @property string $agency_id
 * @property string $owner_id
 * @property Collection $users
 * @property string $id
 * @property string $name
 * @property string $logo
 * @property Address $address
 * @method static create(array $validated)
 * @method static find(string $id)
 */
class Company extends Model
{
    use HasFactory, HasUuids, SoftDeletes;

    protected $casts = [
        'state' => CompanyState::class,
    ];

    protected $fillable = ['name', 'abbreviation', 'vat', 'logo'];

    /**
     * Get the user that owns the company.
     */
    public function owner(): BelongsTo
    {
        return $this->belongsTo(User::class, 'owner_id');
    }

    /**
     * Get the agency that owns the company.
     */
    public function agency(): BelongsTo
    {
        return $this->belongsTo(Agency::class);
    }

    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class)
            ->using(CompanyUser::class)
            ->withPivot('selected')
            ->withTimestamps();
    }

    public function address(): MorphOne
    {
        return $this->morphOne(Address::class, 'addressable');
    }
}
