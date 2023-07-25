<?php

namespace App\Http\Requests\Address;

use App\Constants\Ability;
use App\Models\Address;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Validation\Rule;

/**
 * @property Address $address
 */
class UpdateAddressRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return Auth::check()
            && Gate::allows(Ability::UPDATE, $this->address);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            /* address validation */
            'line_1' => 'required|string|min:3|max:50',
            'line_2' => 'string|max:30',
            'zip_code' => 'required|string|min:3|max:20',
            'city' => 'required|string|min:2|max:30',
            'state_or_region' => 'string|min:2|max:30',
            'country_id' => ['required', 'string', Rule::exists('countries', 'id')],
            'addressable_id' => 'string',
            'addressable_type' => 'string'
        ];
    }
}
