<?php

namespace App\Http\Controllers\Warehouse;

use App\Http\Controllers\Controller;
use App\Models\Country;
use App\Models\Warehouse;
use Illuminate\Database\Eloquent\Collection;

class WarehouseModelController extends Controller
{
    public static function noneActiveCountries(Warehouse $warehouse): Collection
    {
        $active_countries_id = $warehouse->countries()->pluck('id');

        return Country::query()
            ->whereNotIn('id', $active_countries_id)
            ->get();
    }

    public static function removeCountry(Warehouse $warehouse, Country $country): bool
    {
        return $warehouse->countries()
            ->detach($country->id);
    }

    public static function addCountry(Warehouse $warehouse, Country $country): bool
    {
        $warehouse->countries()->syncWithoutDetaching([
            $country->id => ['active' => 1]
        ]);

        return self::hasCountry($warehouse, $country);
    }

    private static function hasCountry(Warehouse $warehouse, Country $country): bool
    {
        return $warehouse->countries()
            ->wherePivot('country_id', '=', $country->id)
            ->exists();
    }

    public static function getCountry(Warehouse $warehouse, Country $country): ?Country
    {
        return $warehouse->countries()
            ->where('id', '=', $country->id)
            ->first();
    }

    public static function getById(string $id): Warehouse
    {
        return Warehouse::find($id);
    }

    public static function delete(mixed $ids): int
    {
        return Warehouse::destroy($ids);
    }

    public static function RandomFirst(): ?Warehouse
    {
        return Warehouse::inRandomOrder()->first();
    }

    public static function getAll(): Collection
    {
        return Warehouse::all();
    }
}
