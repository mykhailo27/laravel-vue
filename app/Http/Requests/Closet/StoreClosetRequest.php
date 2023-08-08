<?php

namespace App\Http\Requests\Closet;

use App\Models\Closet;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class StoreClosetRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return Auth::check();  // todo implement authorization
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
                Rule::unique(Closet::class),
            ],
            'active' => 'numeric', Rule::in([0, 1]),
        ];
    }

    protected function prepareForValidation(): void
    {
        $this->merge([
            'active' => $this->active ? 1 : 0,
        ]);
    }
}
