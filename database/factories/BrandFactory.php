<?php

namespace Database\Factories;

use App\Models\Brand;
use App\Models\Model;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Brand>
 */
class BrandFactory extends Factory
{
    public function definition(): array
    {
        $name = fake()->unique()->lexify();

        return [
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
            ->afterMaking(fn (Brand $brand) => Model::factory($count)
                ->make([
                    'brand_id' => $brand->id,
                ])
            )
            ->afterCreating(fn (Brand $brand) => Model::factory($count)
                ->create([
                    'brand_id' => $brand->id,
                ])
            );
    }
}
