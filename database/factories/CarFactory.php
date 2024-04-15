<?php

namespace Database\Factories;

use App\Models\Brand;
use App\Models\Car;
use App\Models\Equipment;
use App\Models\Model;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Car>
 */
class CarFactory extends Factory
{
    public function definition(): array
    {
        return [
            'brand_id' => Brand::factory(),
            'model_id' => Model::factory(),
            'equipment_id' => Equipment::factory(),
            'vin' => strtoupper(fake()->unique()->bothify('?#9???#????######')),
            'price' => fake()->numberBetween(2_000_000, 10_000_000),
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
