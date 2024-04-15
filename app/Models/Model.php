<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model as Eloquent;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

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
 * @property Collection<Equipment> $equipments Комплектации
 */
class Model extends Eloquent
{
    use HasFactory;

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

    /**
     * Комплектации
     */
    public function equipments(): HasMany
    {
        return $this->hasMany(Equipment::class);
    }
}
