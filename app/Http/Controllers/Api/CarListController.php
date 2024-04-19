<?php

namespace App\Http\Controllers\Api;

use App\Http\Resources\CarResource;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Support\Facades\Redis;

class CarListController
{
    public function __invoke(): AnonymousResourceCollection
    {
        $cars = [];

        foreach (Redis::hGetAll('cars') as $car) {
            $cars[] = json_decode($car);
        }

        return CarResource::collection($cars);
    }
}
