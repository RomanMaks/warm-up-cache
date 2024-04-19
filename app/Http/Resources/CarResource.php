<?php

namespace App\Http\Resources;

use App\Models\Car;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Redis;

/**
 * @mixin Car
 */
class CarResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'brand' => json_decode(Redis::hGet('brands', $this->brand_id)),
            'model' => json_decode(Redis::hGet('models', $this->model_id)),
            'equipment' => json_decode(Redis::hGet('equipments', $this->equipment_id)),
            'vin' => $this->vin,
            'price' => $this->price,
        ];
    }
}
