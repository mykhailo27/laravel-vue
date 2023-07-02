<?php

namespace App\Http\Controllers\Address;

use App\Http\Controllers\Controller;
use App\Models\Address;
use Illuminate\Database\Eloquent\Collection;

class AddressModelController extends Controller
{
    public static function all(): Collection
    {
        return Address::all();
    }

    public static function store(array $attributes): ?Address
    {
        return Address::create($attributes);
    }

    public static function find(string $id): ?Address
    {
        return Address::find($id);
    }

    public static function update(Address $address, array $attributes): bool
    {
        return $address->update($attributes);
    }

    public static function delete(Address $address): bool
    {
        return $address->delete();
    }
}
