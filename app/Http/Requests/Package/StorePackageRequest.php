<?php

namespace App\Http\Requests\Package;

use App\Models\Closet;
use App\Models\User;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class StorePackageRequest extends FormRequest
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
            'name' => 'required|string|max:55',
            'desc' => 'required|max:255',
            'closet_id' => ['required', 'string', Rule::exists(Closet::class, 'id')],
        ];
    }

    protected function prepareForValidation(): void
    {
        /** @var User $user */
        $user = $this->user();

        $this->merge([
            'closet_id' => $user->currentCloset()?->id,
        ]);
    }
}
