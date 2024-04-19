<?php

namespace App\Services;

use App\Models\Brand;
use App\Models\Car;
use App\Models\Equipment;
use App\Models\Model;
use Illuminate\Support\Facades\Redis;
use Illuminate\Support\Str;

class WarmUpCacheService
{
    public function handle(array $cars): void
    {
        $provenBrands = [];

        $provenModels = [];

        $provenEquipments = [];

        foreach ($cars as $car) {
            $keyBrand = $car['brand'];

            if (!isset($provenBrands[$keyBrand])) {
                /** @var Brand $brand */
                $brand = Brand::firstOrCreate(
                    ['name' => $car['brand']],
                    ['slug' => Str::slug($car['brand'])]
                );

                if (!Redis::hExists('brands', $brand->id)) {
                    Redis::hSet('brands', $brand->id, json_encode($brand->toArray()));
                }

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

                if (!Redis::hExists('models', $model->id)) {
                    Redis::hSet('models', $model->id, json_encode($model->toArray()));
                }

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
                        'model_id' => $provenModels[$keyModel],
                        'name' => $car['equipment'],
                        'engine' => $car['engine'],
                        'power' => $car['power'],
                        'transmission' => $car['transmission'],
                        'wheel_drive' => $car['drive'],
                        'options' => $car['options'],
                    ]);
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
                }

                if (!Redis::hExists('equipments', $equipment->id)) {
                    Redis::hSet('equipments', $equipment->id, json_encode($equipment->toArray()));
                }

                $provenEquipments[$keyEquipment] = $equipment->id;
            }

            /** @var Car $existCar */
            $existCar = Car::firstWhere('vin', $car['vin']);

            if (!$existCar) {
                $car = Car::create([
                    'brand_id' => $provenBrands[$keyBrand],
                    'model_id' => $provenModels[$keyModel],
                    'equipment_id' => $provenEquipments[$keyEquipment],
                    'vin' => $car['vin'],
                    'price' => $car['price'],
                ]);

                Redis::hSet('cars', $car->id, json_encode($car->toArray()));
            } elseif ($existCar->price !== $car['price']) {
                $existCar->update([
                    'price' => $car['price'],
                ]);

                Redis::hSet('cars', $existCar->id, json_encode($existCar->toArray()));
            }
        }
    }
}
