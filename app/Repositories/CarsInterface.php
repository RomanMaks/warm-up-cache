<?php

namespace App\Repositories;

interface CarsInterface
{
    /**
     * Method for getting a list of cars for sale
     */
    public function listOfSale(): array;
}
