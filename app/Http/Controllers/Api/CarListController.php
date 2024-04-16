<?php

namespace App\Http\Controllers\Api;

use App\Models\Car;
use Illuminate\Support\Facades\Cache;

class CarListController
{
    public function __invoke()
    {
        if (!Cache::has('cars')) {
            $cars = Car::with(['brand', 'model', 'equipment'])
                ->get()
                ->toArray();

            Cache::forever('cars', $cars);
        }

        return Cache::get('cars');
    }
}
