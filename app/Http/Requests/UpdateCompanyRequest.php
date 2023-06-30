<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class UpdateCompanyRequest extends FormRequest
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
                'string', 'max:55',
                Rule::unique('companies')->ignore($this->company->id),
            ],
            'abbreviation' => [
                'string', 'max:5',
                Rule::unique('companies')->ignore($this->company->id),
            ],
            'vat' => [
                'string', 'min:10', 'max:20',
                Rule::unique('companies')->ignore($this->company->id),
            ],
            'logo' => [
                'string',
                Rule::unique('companies')->ignore($this->company->id),
            ],
        ];
    }
}
