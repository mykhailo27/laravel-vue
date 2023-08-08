<?php

namespace Database\Factories;

use App\Models\Closet;
use App\Models\Company;
use Exception;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Closet>
 */
class ClosetFactory extends Factory
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
        return [
            'id' => $this->newUniqueId(),
            'name' => $this->faker->name,
            'active' => random_int(0, 1)
        ];
    }

    public function configure(): ClosetFactory|Factory
    {
        return $this->afterMaking(function (Closet $closet) {
            $this->assignToCompany($closet);
        });
    }

    public function assignToCompany(Closet $closet): void
    {
        /** @var Company $company */
        $company = Company::inRandomOrder()->first() ?? Company::factory()->create();
        $closet->company_id = $company->id;
    }
}
