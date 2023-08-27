<?php

namespace Database\Factories;

use App\Models\Closet;
use App\Models\Company;
use App\Models\Warehouse;
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
            'active' => random_int(0, 1),
            'company_id' => $this->getCompanyId(),
            'warehouse_id' => $this->getWarehouseId(),
        ];
    }

    public function getCompanyId(): string
    {
        /** @var Company $company */
        $company = Company::inRandomOrder()->first()
            ?: Company::factory()->create();

        return $company->id;
    }

    private function getWarehouseId(): string
    {
        /** @var Warehouse $warehouse */
        $warehouse = Warehouse::inRandomOrder()->first()
            ?: Warehouse::factory()->create();

        return $warehouse->id;
    }
}
