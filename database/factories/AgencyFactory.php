<?php

namespace Database\Factories;

use App\Models\Agency;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Agency>
 */
class AgencyFactory extends Factory
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
            'name' => $this->faker->name,
            'email' => $this->faker->safeEmail,
        ];
    }
}
