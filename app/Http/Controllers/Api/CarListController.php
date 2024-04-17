<?php

namespace App\Http\Controllers\Api;

use App\Models\Car;
use Illuminate\Support\Facades\Cache;

class CarListController
{
    public function __invoke()
    {
        return Cache::rememberForever(
            'cars',
            fn () => Car::with(['brand', 'model', 'equipment'])
                ->get()
                ->toArray()
        );
    }
}
