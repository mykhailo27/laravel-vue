<?php

namespace Database\Factories;

use App\Enums\CompanyState;
use App\Models\Agency;
use App\Models\Closet;
use App\Models\Company;
use App\Models\User;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends Factory<Company>
 */
class CompanyFactory extends Factory
{
    use HasUuids;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $states = CompanyState::values();

        return [
            'id' => $this->newUniqueId(),
            'name' => $this->faker->company,
            'abbreviation' => Str::random(3),
            'vat' => Str::random(15),
            'state' => $states[array_rand($states)],
            'agency_id' => $this->getAgencyId(),
            'owner_id' => $this->getOwnerId(),
        ];
    }

    /**
     * Configure the model factory.
     */
    public function configure(): static
    {
        return $this->afterCreating(function (Company $company) {
            $this->createGeneralCloset($company);
        });
    }

    public function getAgencyId(): string
    {
        /** @var Agency $agency */
        $agency = Agency::inRandomOrder()->first()
            ?? Agency::factory()->create();

        return $agency->id;
    }

    private function getOwnerId(): string
    {
        /** @var User $user */
        $user = User::inRandomOrder()->first()
            ?? User::factory()->create();

        return $user->id;
    }

    private function createGeneralCloset(Company $company): void
    {
        Closet::factory()->create([
            'name' => 'general',
            'company_id' => $company->id,
        ]);
    }
}
