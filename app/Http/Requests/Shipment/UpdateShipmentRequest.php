<?php

namespace App\Http\Requests\Shipment;

use App\Constants\Ability;
use App\Models\Shipment;
use App\Models\User;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

/**
 * @property Shipment $shipment
 */
class UpdateShipmentRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        /** @var User $user */
        $user = $this->user();

        return $user->can(Ability::UPDATE, $this->shipment);
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
