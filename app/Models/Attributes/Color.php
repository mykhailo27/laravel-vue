<?php

namespace App\Models\Attributes;

use App\Models\Variation;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphMany;

class Color extends Model implements Attribute
{
    private string $type = 'color';

    protected $fillable = ['name', 'value'];

    public function variations(): MorphMany
    {
        return $this->morphMany(Variation::class, 'variable');
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getValue(): string
    {
        return $this->value;
    }

    public function getType(): string
    {
        return $this->type;
    }
}
