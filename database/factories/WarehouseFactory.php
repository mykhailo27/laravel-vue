<?php

namespace Database\Factories;

use App\Enums\Currency;
use App\Models\Address;
use App\Models\Country;
use App\Models\User;
use App\Models\Warehouse;
use Exception;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Warehouse>
 */
class WarehouseFactory extends Factory
{
    use HasUuids;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     * @throws Exception
     */
    public function definition(): array
    {
        $currency = Currency::values();

        return [
            'id' => $this->newUniqueId(),
            'name' => $this->faker->name,
            'return_cost' => random_int(20, 100),
            'currency' => $currency[array_rand($currency)],
        ];
    }

    public function configure(): static
    {
        return $this->afterMaking(function (Warehouse $warehouse) {

            $this->addAddress($warehouse);
            $this->addCountries($warehouse);
            $this->assignResponsibleUser($warehouse);

            return $warehouse;
        });
    }

    private function addAddress(Warehouse $warehouse): void
    {
        Address::factory()->create([
            'addressable_id' => $warehouse->id,
            'addressable_type' => Warehouse::class
        ]);
    }

    /**
     * @throws Exception
     */
    private function addCountries(Warehouse $warehouse): void
    {
        $countries_id = Country::orderByRaw('RAND()')->take(10)->get('id')->pluck('id');
        $warehouse->countries()->attach($countries_id, [
            'active' => random_int(0, 1)
        ]);
    }

    private function assignResponsibleUser(Warehouse $warehouse): void
    {
        /** @var User $user */
        $user = User::inRandomOrder()->first() ?? User::factory()->create();

        $warehouse->responsible_user_id = $user->id;
    }
}
