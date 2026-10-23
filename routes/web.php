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
use Illuminate\Support\Facades\Route;

// Sitio público
Route::get('/inicio', [InicioController::class, 'index'])->name('inicio');
Route::get('/propiedades/{id}', [InicioController::class, 'show'])->name('propiedad.show');

// Zona administrativa (requiere sesión)
Route::middleware('auth')->group(function () {
    Route::get('/admin', [DashboardController::class, 'index'])->name('dashboard.index');

    Route::resource('municipio', MunicipioController::class);
    Route::resource('tipo_inmueble', TipoInmuebleController::class);
    Route::resource('usuario', UsuarioController::class);
    Route::resource('barrio', BarrioController::class);
    Route::resource('inmueble', InmuebleController::class);
    Route::resource('detalle_inmueble', DetalleInmuebleController::class);
    Route::resource('imagen', ImagenController::class)->only(['index', 'destroy']);
});

// Login, logout y módulo de seguridad
require __DIR__.'/seguridad.php';