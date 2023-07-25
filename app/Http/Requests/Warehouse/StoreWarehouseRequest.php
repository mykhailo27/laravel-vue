<?php

namespace App\Http\Requests\Warehouse;

use App\Enums\Currency;
use App\Models\User;
use App\Models\Warehouse;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class StoreWarehouseRequest extends FormRequest
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
                Rule::unique(Warehouse::class),
            ],
            'return_cost' => [
                'required', 'decimal:0,2',
            ],
            'currency' => [
                'required', 'string',
                Rule::in(Currency::values()),
            ],
            'responsible_user_id' => Rule::exists(User::class, 'id')
        ];
    }
}
