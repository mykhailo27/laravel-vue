<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Country extends Model
{
    use HasFactory, HasUuids;

    protected $casts = [
        'aliases' => 'array'
    ];

    protected $fillable = ['name', 'alpha_2', 'alpha_3', 'enabled', 'aliases', 'zip_code_regex'];
}
