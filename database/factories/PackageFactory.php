<?php

namespace Database\Factories;

use App\Http\Controllers\Closet\ClosetModelController;
use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Package;
use App\Models\Closet;

/**
 * @extends Factory<Package>
 */
class PackageFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'id' => $this->faker->uuid,
            'name' => $this->faker->name,
            'desc' => $this->faker->sentence,
            'closet_id' => $this->getClosetId()
        ];
    }

    private function getClosetId(): string
    {
        $closet = ClosetModelController::getFirstRandom()
            ?? Closet::factory()->create();

        return $closet->id;
    }
}
