<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model as Eloquent;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * Сущность "Комплектация"
 *
 * @property int $id
 * @property int $model_id        ID Модели
 * @property string $name         Наименование
 * @property string $engine       Двигатель
 * @property int $power           Мощность
 * @property string $transmission Коробка
 * @property string $drive        Привод
 * @property array $options       Опции
 * @property Carbon $created_at Дата и время создания
 * @property Carbon $updated_at Дата и время обновления
 *
 * @property Model $model Модель
 */
class Equipment extends Eloquent
{
    protected $fillable = [
        'model_id',
        'name',
        'engine',
        'power',
        'transmission',
        'drive',
        'options',
    ];

    protected $casts = [
        'options' => 'array',
    ];

    /**
     * Модель
     */
    public function model(): BelongsTo
    {
        return $this->belongsTo(Model::class);
    }
}