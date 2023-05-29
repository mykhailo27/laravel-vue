<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @property string $id
 * @property string $name
 * @property string $email
 * @method static create(string[] $array)
 * @method static paginate(int $int)
 */
class Agency extends Model
{
    use HasFactory, HasUuids, SoftDeletes;

    protected $fillable = ['name', 'email'];


    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class)
            ->using(AgencyUser::class)
            ->withPivot('selected')
            ->withTimestamps();
    }

    public function hasUser(User $user): bool
    {
        return $this->users()
            ->wherePivot('user_id', '=', $user->id)
            ->exists();
    }

    public function addUser(User $user): bool
    {
        $this->users()->attach($user->id);

        return $this->hasUser($user);
    }

    public function nonAgencyUser()
    {
        $users_id = $this->users()->pluck('user_id')->toArray();

        return User::whereNotIn('id', $users_id)->get();
    }
}
