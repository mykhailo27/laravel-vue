<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasPermissions;
use Spatie\Permission\Traits\HasRoles;

/**
 * @property string $id
 * @property string $name
 * @property string $email
 * @method static whereNotIn(string $column, mixed[] $values)
 * @method static find(string $id)
 */
class User extends Authenticatable implements MustVerifyEmail
{
    use HasApiTokens, HasUuids, HasFactory, Notifiable, HasRoles, HasPermissions;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    public function agencies(): BelongsToMany
    {
        return $this->belongsToMany(Agency::class)
            ->using(AgencyUser::class)
            ->withPivot('selected')
            ->withTimestamps();
    }

    public function selectedAgency(): Agency
    {
        return $this->agencies()
            ->wherePivot('selected', '=', true)
            ->first();
    }

    public function selectedCompany(array $columns = ['*']): ?Company
    {
        return $this->companies()
            ->wherePivot('selected', '=', true)
            ->first($columns);
    }

    public function companies(): BelongsToMany
    {
        return $this->belongsToMany(Company::class)
            ->using(CompanyUser::class)
            ->withPivot('selected')
            ->withTimestamps();
    }

    public function closets(): BelongsToMany
    {
        return $this->belongsToMany(Closet::class)
            ->using(ClosetUser::class)
            ->withPivot('active')
            ->withTimestamps();
    }

    public function selectedCloset(Company $company, array $columns = ['*']): ?Closet
    {
        return $this->closets()
            ->where('closets.company_id', '=', $company->id)
            ->wherePivot('active', '=', true)
            ->first($columns);
    }
}
