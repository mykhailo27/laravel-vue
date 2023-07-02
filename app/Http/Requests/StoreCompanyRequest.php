<?php

namespace App\Http\Requests;

use App\Models\Company;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\File;

class StoreCompanyRequest extends FormRequest
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
            'name' => [
                'required', 'string', 'max:55',
                Rule::unique(Company::class),
            ],
            'abbreviation' => [
                'required', 'string', 'max:5',
                Rule::unique(Company::class),
            ],
            'vat' => [
                'required', 'string', 'min:10', 'max:20',
                Rule::unique(Company::class),
            ],

            /* address validation */
            'address_line_1' => 'required|string|min:5|max:20',
            'address_line_2' => 'string|min:2|max:20',
            'address_zip_code' => 'required|string|min:3|max:10',
            'address_city' => 'required|string|min:3|max:20',
            'address_state_or_region' => 'string|min:5|max:20',
            'address_country' => ['required', 'string', Rule::exists('countries', 'id')],

            'logo' => [
                'required',
                File::image()
                    /*->min(1024) todo update the validation, to match the expected image size and dimension
                    ->max(12 * 1024)
                    ->dimensions(Rule::dimensions()->maxWidth(500)->maxHeight(500))*/,
                Rule::unique(Company::class),
            ],
        ];
    }
}
