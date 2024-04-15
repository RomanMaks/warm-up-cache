<?php

namespace Database\Seeders;

use App\Models\Brand;
use App\Models\Car;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Seeder;

class CarSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        if (config('app.env') === 'local') {
            /** @var Collection<Brand> $brands */
            $brands = Brand::factory(5)->create();

            foreach ($brands as $brand) {
                foreach ($brand->models as $model) {
                    foreach ($model->equipments as $equipment) {
                        Car::factory(fake()->numberBetween(1, 2))->create([
                            'brand_id' => $brand->id,
                            'model_id' => $model->id,
                            'equipment_id' => $equipment->id,
                        ]);
                    }
                }
            }
        }
    }
}
