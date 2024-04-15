<?php

namespace App\Models\Enums;

enum TransmissionEnum: string {
    case Robot = 'робот';
    case Automatic = 'автоматическая';
    case Variator = 'вариатор';
    case Manual = 'механическая';
}
