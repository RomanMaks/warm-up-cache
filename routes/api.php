<?php

use App\Http\Controllers\Api\CarListController;
use Illuminate\Support\Facades\Route;

Route::get('car/list', CarListController::class)->name('car.list');
