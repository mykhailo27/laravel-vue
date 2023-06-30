<?php

namespace App\Http\Requests\Role;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use App\Models\Role;

class UpdateRoleRequest extends FormRequest
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
                Rule::unique(Role::class)
                    ->ignore($this->role->id)
            ],
            'guard_name' => [
                'string', 'max:255',
                Rule::in(['web']), // todo check if another guard has been added
            ],
        ];
    }
}
