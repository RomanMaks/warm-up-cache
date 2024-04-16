<?php

namespace App\Services;

use App\Models\Brand;
use App\Models\Car;
use App\Models\Equipment;
use App\Models\Model;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Str;

class WarmUpCacheService
{
    public function handle(array $cars): void
    {
        $provenBrands = [];

        $provenModels = [];

        $provenEquipments = [];

        $isNecessaryUpdateCache = false;

        foreach ($cars as $car) {
            $keyBrand = $car['brand'];

            if (!isset($provenBrands[$keyBrand])) {
                /** @var Brand $brand */
                $brand = Brand::firstOrCreate(
                    ['name' => $car['brand']],
                    ['slug' => Str::slug($car['brand'])]
                );

                $provenBrands[$keyBrand] = $brand->id;
            }

            $keyModel = $keyBrand . '_' . $car['model'];

            if (!isset($provenModels[$keyModel])) {
                /** @var Model $model */
                $model = Model::whereBrandName($car['brand'])
                    ->firstOrCreate(
                        ['name' => $car['model']],
                        [
                            'brand_id' => $provenBrands[$keyBrand],
                            'slug' => Str::slug($car['model'])
                        ]
                    );

                $provenModels[$keyModel] = $model->id;
            }

            $keyEquipment = $keyModel . '_' . $car['equipment'];

            if (!isset($provenEquipments[$keyEquipment])) {
                /** @var ?Equipment $equipment */
                $equipment = Equipment::whereBrandAndModel($car['brand'], $car['model'])
                    ->firstWhere('name', $car['equipment']);

                if (!$equipment) {
                    /** @var Equipment $equipment */
                    $equipment = Equipment::create([
                        'name' => $car['equipment'],
                        'engine' => $car['engine'],
                        'power' => $car['power'],
                        'transmission' => $car['transmission'],
                        'wheel_drive' => $car['drive'],
                        'options' => $car['options'],
                    ]);

                    $isNecessaryUpdateCache = true;
                } elseif (
                    $equipment->engine != $car['engine'] ||
                    $equipment->power != $car['equipment'] ||
                    $equipment->transmission != $car['transmission'] ||
                    $equipment->wheel_drive != $car['drive']
                ) {
                    $equipment->update([
                        'engine' => $car['engine'],
                        'power' => $car['power'],
                        'transmission' => $car['transmission'],
                        'wheel_drive' => $car['drive'],
                        'options' => $car['options'],
                    ]);

                    $isNecessaryUpdateCache = true;
                }

                $provenEquipments[$keyEquipment] = $equipment->id;
            }

            /** @var Car $existCar */
            $existCar = Car::firstWhere('vin', $car['vin']);

            if (!$existCar) {
                Car::create([
                    'brand_id' => $provenBrands[$keyBrand],
                    'model_id' => $provenModels[$keyModel],
                    'equipment' => $provenEquipments[$keyEquipment],
                    'vin' => $car['vin'],
                    'price' => $car['price'],
                ]);

                $isNecessaryUpdateCache = true;
            } elseif ($existCar->price !== $car['price']) {
                $existCar->update([
                    'price' => $car['price'],
                ]);

                $isNecessaryUpdateCache = true;
            }
        }

        // Если данные отличаются, необходимо обновить информацию в базе данных
        // MySQL и прогреть кеш Redis.

        if ($isNecessaryUpdateCache) {
            $cars = Car::with(['brand', 'model', 'equipment'])
                ->get()
                ->toArray();

            Cache::forever('cars', $cars);
        }
    }
}
