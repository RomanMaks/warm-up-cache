<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model as Eloquent;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * Сущность "Автомобиль"
 *
 * @property int $id
 * @property int $brand_id      ID Марки
 * @property int $model_id      ID Модели
 * @property int $equipment_id  ID Комплектации
 * @property string $vin        VIN номер авто
 * @property string $price      Цена
 * @property Carbon $created_at Дата и время создания
 * @property Carbon $updated_at Дата и время обновления
 *
 * @property Brand $brand Марка
 * @property Model $model Модель
 * @property Equipment $equipment Комплектация
 */
class Car extends Eloquent
{
    protected $fillable = [
        'brand_id',
        'model_id',
        'equipment_id',
        'vin',
        'price',
    ];

    /**
     * Марка
     */
    public function brand(): BelongsTo
    {
        return $this->belongsTo(Brand::class);
    }

    /**
     * Модель
     */
    public function model(): BelongsTo
    {
        return $this->belongsTo(Model::class);
    }

    /**
     * Комплектация
     */
    public function equipment(): BelongsTo
    {
        return $this->belongsTo(Equipment::class);
    }
}
