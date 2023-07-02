<?php

namespace App\Http\Requests\Agency;

use App\Constants\Ability;
use App\Models\Agency;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Validation\Rule;

class StoreAgencyRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return Auth::check()
            && Gate::allows(Ability::CREATE, Agency::class);
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
                Rule::unique(Agency::class),
            ],
            'email' => [
                'required', 'email', 'max:255',
                Rule::unique(Agency::class),
            ],
        ];
    }
}
