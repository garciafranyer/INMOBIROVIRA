<?php

use App\Http\Controllers\BarrioController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DetalleInmuebleController;
use App\Http\Controllers\ImagenController;
use App\Http\Controllers\InicioController;
use App\Http\Controllers\InmuebleController;
use App\Http\Controllers\MunicipioController;
use App\Http\Controllers\TipoInmuebleController;
use App\Http\Controllers\UsuarioController;
use App\Models\detalle_inmueble;
use Illuminate\Support\Facades\Route;

Route::get('/admin', [DashboardController::class, 'index'])
        ->name('dashboard.index');

// Sitio público
Route::get('/', [InicioController::class, 'index'])->name('inicio');
Route::get('/propiedades/{id}', [InicioController::class, 'show'])->name('propiedad.show');

route::resource('municipio', MunicipioController::class);

route::resource('tipo_inmueble', TipoInmuebleController::class);

route::resource('usuario', UsuarioController::class);

route::resource('barrio', BarrioController::class);

route::resource('inmueble',InmuebleController::class);

route::resource('detalle_inmueble',DetalleInmuebleController::class);

route::resource('imagen',ImagenController::class);

Route::resource('imagen', ImagenController::class)->only(['index', 'destroy']);


