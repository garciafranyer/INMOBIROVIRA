<?php

use App\Http\Controllers\BarrioController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DetalleInmuebleController;
use App\Http\Controllers\EmpresaInmuebleController;
use App\Http\Controllers\ImagenController;
use App\Http\Controllers\InicioController;
use App\Http\Controllers\InmuebleController;
use App\Http\Controllers\MunicipioController;
use App\Http\Controllers\TipoInmuebleController;
use App\Http\Controllers\UsuarioController;
use Illuminate\Support\Facades\Route;

// Sitio público (pantalla principal al ingresar al dominio)
Route::get('/', [InicioController::class, 'index'])->name('inicio');
Route::get('/inicio', [InicioController::class, 'index']);
Route::get('/propiedades/{id}', [InicioController::class, 'show'])->name('propiedad.show');

// Zona administrativa (requiere sesión y no almacena en caché)
Route::middleware(['auth', 'nocache'])->group(function () {
    Route::get('/admin', [DashboardController::class, 'index'])->name('dashboard.index');

    Route::resource('municipio', MunicipioController::class);
    Route::resource('tipo_inmueble', TipoInmuebleController::class);
    Route::resource('usuario', UsuarioController::class);
    Route::resource('barrio', BarrioController::class);
    Route::patch('inmueble/{id}/estado', [InmuebleController::class, 'actualizarEstado'])->name('inmueble.estado');
    Route::resource('inmueble', InmuebleController::class);
    Route::resource('detalle_inmueble', DetalleInmuebleController::class);
    Route::resource('imagen', ImagenController::class)->only(['index', 'destroy']);
});

// Portal exclusivo para empresas inmobiliarias (requiere sesión)
Route::middleware(['auth', 'nocache'])->prefix('empresa')->name('empresa.')->group(function () {
    Route::get('/', [EmpresaInmuebleController::class, 'index'])->name('index');
    Route::get('/inmuebles/crear', [EmpresaInmuebleController::class, 'create'])->name('crear');
    Route::post('/inmuebles', [EmpresaInmuebleController::class, 'store'])->name('store');
    Route::get('/inmuebles/{id}/editar', [EmpresaInmuebleController::class, 'edit'])->name('edit');
    Route::put('/inmuebles/{id}', [EmpresaInmuebleController::class, 'update'])->name('update');
    Route::delete('/inmuebles/{id}', [EmpresaInmuebleController::class, 'destroy'])->name('destroy');
    Route::patch('/inmuebles/{id}/estado', [EmpresaInmuebleController::class, 'actualizarEstado'])->name('estado');
});

// Login, logout y módulo de seguridad
require __DIR__.'/seguridad.php';
