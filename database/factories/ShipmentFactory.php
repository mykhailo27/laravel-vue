<?php

namespace Database\Factories;

use App\Http\Controllers\Closet\ClosetModelController;
use App\Http\Controllers\Shipment\ShipmentModelController;
use App\Http\Controllers\User\UserModelController;
use App\Http\Controllers\Variant\VariantModelController;
use App\Models\User;
use App\Models\Variant;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Shipment;
use App\Models\Address;
use App\Models\Closet;

/**
 * @extends Factory<Shipment>
 */
class ShipmentFactory extends Factory
{
    use HasUuids;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'id' => $this->newUniqueId(),
            'recipient_name' => $this->faker->name,
            'recipient_email' => $this->faker->email,
            'recipient_phone' => $this->faker->phoneNumber,
            'closet_id' => $this->getClosetId(),
            'supplier_id' => $this->getSupplierId(),
        ];
    }

    public function configure(): ShipmentFactory
    {
        return $this->afterCreating(function (Shipment $shipment) {
            $this->addAddress($shipment);
            $this->addVariants($shipment);
        });
    }

    /**
     * @param Shipment $shipment
     * @return void
     */
    function addAddress(Shipment $shipment): void
    {
        Address::factory()->create([
            'addressable_id' => $shipment->id,
            'addressable_type' => Shipment::class
        ]);
    }

    private function getClosetId(): string
    {
        $closet = ClosetModelController::getFirstRandom()
            ?? Closet::factory()->create();

        return $closet->id;
    }

    private function getSupplierId(): string
    {
        $supplier = UserModelController::getFirstRandom()
            ?? User::factory()->create();

        return $supplier->id;
    }

    private function addVariants(Shipment $shipment): void
    {
        $closet = $shipment->closet;
        $variants = VariantModelController::getVariantsInCloset($closet, ['id']);

        $variants->map(function (Variant $variant) use ($shipment, $closet) {
            $inventory = VariantModelController::getInventoryInCloset($variant, $closet);

            if (($amount = random_int(1, $inventory->in_stock)) > 0) {
                ShipmentModelController::addVariant($shipment, $variant, $amount);
            }
        });
    }
}
