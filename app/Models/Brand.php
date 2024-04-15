<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model as Eloquent;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * Сущность "Марка"
 *
 * @property int $id
 * @property string $name       Наименование
 * @property string $slug       Код
 * @property Carbon $created_at Дата и время создания
 * @property Carbon $updated_at Дата и время обновления
 *
 * @property Collection<Model> $models Модели
 */
class Brand extends Eloquent
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
    ];

    /**
     * Модели
     */
    public function models(): HasMany
    {
        return $this->hasMany(Model::class);
    }
}
