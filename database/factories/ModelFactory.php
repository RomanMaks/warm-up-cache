<?php

namespace Database\Factories;

use App\Models\Brand;
use App\Models\Equipment;
use App\Models\Model;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Model>
 */
class ModelFactory extends Factory
{
    public function definition(): array
    {
        $name = fake()->bothify('?#');

        return [
            'brand_id' => Brand::factory(),
            'name' => strtoupper($name),
            'slug' => $name,
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }

    public function configure(): static
    {
        $count = fake()->randomNumber(1, 3);

        return $this
            ->afterMaking(fn (Model $model) => Equipment::factory($count)
                ->make([
                    'model_id' => $model->id,
                ])
            )
            ->afterCreating(fn (Model $model) => Equipment::factory($count)
                ->create([
                    'model_id' => $model->id,
                ])
            );
    }
}
