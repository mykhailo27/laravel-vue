<?php

namespace App\Http\Requests\Country;

use App\Models\Country;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

/**
 * @property Country $country
 */
class UpdateCountryRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return Auth::check(); // todo implement authorization
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'name' => Rule::unique(Country::class)->ignore($this->country->id),
            'alpha_2' => 'string|min:2|max:2',
            'alpha_3' => 'string|min:3|max:3',
            'enabled' => 'numeric', Rule::in([0, 1]),
            'aliases' => 'array',
            'zip_code_regex' => 'string',
        ];
    }

    protected function prepareForValidation(): void
    {
        $this->merge([
            'enabled' => $this->enabled ? 1 : 0,
        ]);
    }
}
