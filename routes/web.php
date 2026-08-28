<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\MunicipioController;
use Illuminate\Support\Facades\Route;

Route::get('/', [DashboardController::class, 'index'])
        ->name('dashboard.index');

route::resource('municipio', MunicipioController::class);


