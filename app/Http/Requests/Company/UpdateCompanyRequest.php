<?php

namespace App\Http\Requests\Company;

use App\Models\Company;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\File;

/**
 * @property Company $company
 */
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
                File::image()
                    /*->min(1024) todo update the validation, to match the expected image size and dimension
                    ->max(12 * 1024)
                    ->dimensions(Rule::dimensions()->maxWidth(500)->maxHeight(500))*/,
                Rule::unique('companies')->ignore($this->company->id),
            ],
        ];
    }
}
