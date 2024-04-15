<?php

namespace App\Models\Enums;

enum WheelDriveEnum: string {
    case Front = 'передний';
    case Rear = 'задний';
    case Full = 'полный';
}
