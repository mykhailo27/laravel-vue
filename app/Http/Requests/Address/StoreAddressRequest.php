<?php

namespace App\Http\Requests\Address;

use App\Constants\Ability;
use App\Models\Address;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Validation\Rule;

class StoreAddressRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return Auth::check()
            && Gate::allows(Ability::CREATE, Address::class);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'line_1' => 'required|string|min:5|max:20',
            'line_2' => 'string|min:2|max:20',
            'zip_code' => 'required|string|min:3|max:10',
            'city' => 'required|string|min:3|max:20',
            'state_or_region' => 'string|min:5|max:20',
            'country_id' => ['required', 'string', Rule::exists('countries', 'id')],
            'addressable_id' => 'required|string',
            'addressable_type' => 'required|string',
        ];
    }
}
