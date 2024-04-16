<?php

namespace App\DTOs;

use Illuminate\Contracts\Support\Arrayable;

abstract class DataTransferObject implements Arrayable
{
    public function toArray(): array
    {
        return (array) $this;
    }
}
