<?php

namespace App\Models;

use App\Enums\ShipmentState;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

/**
 * @property User $supplier
 * @property string $recipient_name
 * @property string $recipient_email
 * @property string $recipient_phone
 * @property Carbon $created_at
 * @property string $state
 * @property Address $address
 * @property Collection $variants
 * @property Closet $closet
 */
class Shipment extends Model
{
    use HasFactory, HasUuids, SoftDeletes;

    protected $fillable = ['recipient_name', 'recipient_email', 'recipient_phone'];

    protected $casts = [
        'state' => ShipmentState::class
    ];

    public function closet(): BelongsTo
    {
        return $this->belongsTo(Closet::class);
    }

    public function address(): MorphOne
    {
        return $this->morphOne(Address::class, 'addressable');
    }

    public function supplier(): BelongsTo
    {
        return $this->belongsTo(User::class, 'supplier_id');
    }

    public function variants(): BelongsToMany
    {
        return $this->belongsToMany(Variant::class)
            ->using(ShipmentVariant::class)
            ->withPivot('quantity')
            ->withTimestamps();
    }
}
