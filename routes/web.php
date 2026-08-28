<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\MunicipioController;
use App\Http\Controllers\TipoInmuebleController;
use Illuminate\Support\Facades\Route;

Route::get('/', [DashboardController::class, 'index'])
        ->name('dashboard.index');

route::resource('municipio', MunicipioController::class);

route::resource('tipo_inmueble', TipoInmuebleController::class);


