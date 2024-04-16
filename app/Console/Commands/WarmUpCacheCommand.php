<?php

namespace App\Console\Commands;

use App\Repositories\CarsInterface;
use App\Services\WarmUpCacheService;
use Illuminate\Console\Command;

class WarmUpCacheCommand extends Command
{
    protected $signature = 'warm-up-cache';

    protected $description = 'The command to warm up the cache.';

    public function __construct(
        private readonly CarsInterface $repository,
        private readonly WarmUpCacheService $service
    ) {
        parent::__construct();
    }

    public function handle(): void
    {
        $cars = $this->repository->listOfSale();

        $this->service->handle($cars);
    }
}
