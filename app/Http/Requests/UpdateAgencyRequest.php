<?php

namespace App\Http\Requests;

use App\Models\Agency;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

/**
 * @property Agency $agency
 */
class UpdateAgencyRequest extends FormRequest
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
                Rule::unique('agencies')->ignore($this->agency->id),
            ],
            'email' => [
                'email', 'max:255',
                Rule::unique(Agency::class)->ignore($this->agency->id),
            ],
        ];
    }
}
