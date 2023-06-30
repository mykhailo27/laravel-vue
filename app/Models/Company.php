<?php

namespace App\Models;

use App\Enums\CompanyState;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @property string $agency_id
 * @property string $owner_id
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
}
