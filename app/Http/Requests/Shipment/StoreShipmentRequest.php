<?php

namespace App\Http\Requests\Shipment;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use App\Constants\Ability;
use App\Models\Shipment;

class StoreShipmentRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        $user = $this->user();

        return $user->can(Ability::CREATE, Shipment::class);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'recipient_name' => 'required|string|max:50',
            'recipient_email' => 'required|string|max:50',
            'recipient_phone' => 'required|string|max:50',
        ];
    }
}
