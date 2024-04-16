<?php

namespace App\Repositories;

//use App\Connections\HttpConnectorInterface;
use App\Models\Brand;
use App\Models\Equipment;
use App\Models\Model;

class StubApiServiceCarRepository implements CarsInterface
{
    private array $brands = [
        'Volkswagen' => [
            'Golf' => [
                'Trendline' => 'XW8ZZZ5NZAG123456',
                'Comfortline' => 'XW8Z1A5NZAG123446',
                'Highline' => 'XW8DDZ5NZ3G123456',
            ],
        ],
        'Audi' => [
            'A4' => [
                '35 TFSI S tronic Edition One' => 'RS8ZRZ4NZAG123456',
            ],
        ],
    ];

//    public function __construct(private HttpConnectorInterface $connector)
//    {
//    }

    public function listOfSale(): array
    {
        // TODO: This you can uses "$this->connector->request(new DataTransferObject(...));" for getting a list of cars for sale

        $result = [];

        foreach ($this->brands as $brand => $models) {
            $brand = Brand::factory()->make([
                'name' => $brand,
                'slug' => strtolower($brand),
            ]);

            foreach ($models as $model => $equipments) {
                $model = Model::factory()->make([
                    'brand_id' => $brand->id,
                    'name' => $model,
                    'slug' => strtolower($model),
                ]);

                foreach ($equipments as $equipment => $vin) {
                    $equipment = Equipment::factory()->make([
                        'model_id' => $model->id,
                        'name' => $equipment,
                    ]);

                    $result[] = [
                        'brand' => $brand->name,
                        'model' => $model->name,
                        'equipment' => $equipment->name,
                        'vin' => $vin,
                        'price' => fake()->numberBetween(3_000_000, 5_000_000),
                        'engine' => $equipment->engine,
                        'power' => $equipment->power,
                        'transmission' => $equipment->transmission,
                        'drive' => $equipment->wheel_drive,
                        'options' => $equipment->options,
                    ];
                }
            }
        }

        return $result;
    }
}
