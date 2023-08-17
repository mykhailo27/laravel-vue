<?php

namespace App\Http\Controllers\Variation;

use App\Http\Controllers\Controller;
use App\Models\Attributes\Attribute;
use App\Models\Variant;
use App\Models\Variation;

class VariationModelController extends Controller
{
    public static function delete(mixed $ids): int
    {
        return Variation::destroy($ids);
    }

    public static function getById(string $id): Variation
    {
        return Variation::find($id);
    }

    public static function getSizeFor(Variant $variant): string
    {
        $size_variation = $variant->variations()
            ->where('name', '=', 'size')
            ->first();

        $variable = $size_variation->variable;

        return $variable->getValue();
    }

    public static function getColorFor(Variant $variant): string
    {
        $size_variation = $variant->variations()
            ->where('name', '=', 'color')
            ->first();

        /** @var Attribute $variable */
        $variable = $size_variation->variable;

        return $variable->getName();
    }

    public static function createFor($variant, Attribute $attribute): ?Variation
    {
        return Variation::create([
            'name' => $attribute->getType(),
            'variable_id' => $attribute->id,
            'variable_type' => get_class($attribute),
            'variant_id' => $variant->id
        ]);
    }
}
