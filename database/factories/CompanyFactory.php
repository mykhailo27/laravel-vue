<?php

namespace Database\Factories;

use App\Enums\CompanyState;
use App\Models\Agency;
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
        ];
    }

    /**
     * Configure the model factory.
     */
    public function configure(): static
    {
        return $this->afterMaking(function (Company $company) {

            $this->assignToAgency($company);
            $this->assignToOwner($company);

            return $company;
        });
    }

    public function assignToAgency(Company $company): void
    {
        /** @var Agency $agency */
        $agency = Agency::inRandomOrder()->first() ?? Agency::factory()->create();
        $company->agency_id = $agency->id;
    }

    private function assignToOwner(Company $company): void
    {
        /** @var User $user */
        $user = User::inRandomOrder()->first() ?? User::factory()->create();
        $company->owner_id = $user->id;
    }
}
