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

    protected $fillable = ['name', 'alpha_1', 'alpha_2', 'aliases', 'zip_code_regex'];
}
