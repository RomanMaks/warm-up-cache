<?php

namespace App\Connections;

use App\DTOs\DataTransferObject;

interface HttpConnectorInterface
{
    public function request(DataTransferObject $request): array;
}
