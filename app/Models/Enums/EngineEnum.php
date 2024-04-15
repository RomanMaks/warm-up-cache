<?php

namespace App\Models\Enums;

enum EngineEnum: string {
    case Petrol = 'бензиновый';
    case Diesel = 'дизельный';
    case Electric = 'электрический';
    case Gas = 'газовый';
}
