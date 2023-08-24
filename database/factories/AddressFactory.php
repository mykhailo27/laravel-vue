<?php

namespace Database\Factories;

use App\Models\Address;
use App\Models\Country;
use Exception;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Address>
 */
class AddressFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     * @throws Exception
     */
    public function definition(): array
    {
        return [
            'line_1' => $this->faker->streetAddress,
            'line_2' => random_int(1, 50),
            'zip_code' => $this->faker->postcode,
            'city' => $this->faker->city,
            'state_or_region' => $this->faker->name,
            'country_id' => $this->getCountryId()
        ];
    }

    private function getCountryId(): string
    {
        /** @var Country $country */
        $country = Country::inRandomOrder()->first();

        return $country->id;
    }
}
