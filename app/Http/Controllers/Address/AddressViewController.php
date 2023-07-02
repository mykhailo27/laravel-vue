<?php

namespace App\Http\Controllers\Address;

use App\Http\Controllers\Controller;
use App\Http\Requests\Address\StoreAddressRequest;
use App\Http\Requests\Address\UpdateAddressRequest;
use App\Models\Address;
use Illuminate\Http\RedirectResponse;

class AddressViewController extends Controller
{
    public function store(StoreAddressRequest $request): RedirectResponse
    {
        return is_null(AddressModelController::store($request->validated()))
            ? back()->withErrors(['error' => 'fail to store address'])
            : back()->with('message', 'address created');
    }

    public function update(UpdateAddressRequest $request, Address $address): RedirectResponse
    {
        return AddressModelController::update($address, $request->validated())
            ? back()->with('message', 'address updated')
            : back()->withErrors(['error' => 'fail to update address']);
    }
}
