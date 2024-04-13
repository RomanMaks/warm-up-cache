<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model as Eloquent;

/**
 * Сущность "Марка"
 *
 * @property int $id
 * @property string $name       Наименование
 * @property string $slug       Код
 * @property Carbon $created_at Дата и время создания
 * @property Carbon $updated_at Дата и время обновления
 */
class Brand extends Eloquent
{
    protected $fillable = [
        'name',
        'slug',
    ];
}
