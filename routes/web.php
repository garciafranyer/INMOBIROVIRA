<?php

use App\Http\Controllers\BarrioController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\InmuebleController;
use App\Http\Controllers\MunicipioController;
use App\Http\Controllers\TipoInmuebleController;
use App\Http\Controllers\UsuarioController;
use Illuminate\Support\Facades\Route;

Route::get('/', [DashboardController::class, 'index'])
        ->name('dashboard.index');

route::resource('municipio', MunicipioController::class);

route::resource('tipo_inmueble', TipoInmuebleController::class);

route::resource('usuario', UsuarioController::class);

route::resource('barrio', BarrioController::class);

route::resource('inmueble',InmuebleController::class);


