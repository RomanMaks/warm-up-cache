<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model as Eloquent;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * Сущность "Модель"
 *
 * @property int $id
 * @property int $brand_id     ID Бренда
 * @property string $name      Наименование
 * @property string $slug      Код
 * @property Carbon$created_at Дата и время создания
 * @property Carbon$updated_at Дата и время обновления
 *
 * @property Brand $brand Бренд
 */
class Model extends Eloquent
{
    protected $fillable = [
        'brand_id',
        'name',
        'slug',
    ];

    /**
     * Бренд
     */
    public function brand(): BelongsTo
    {
        return $this->belongsTo(Brand::class);
    }
}
