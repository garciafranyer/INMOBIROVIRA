<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Repositories\Contracts\InmuebleRepositoryInterface;
use App\Repositories\InmuebleRepository;
use App\Repositories\Contracts\MunicipioRepositoryInterface;
use App\Repositories\MunicipioRepository;
use App\Repositories\Contracts\BarrioRepositoryInterface;
use App\Repositories\BarrioRepository;
use App\Repositories\Contracts\TipoInmuebleRepositoryInterface;
use App\Repositories\TipoInmuebleRepository;
use App\Repositories\Contracts\ImagenRepositoryInterface;
use App\Repositories\ImagenRepository;
use App\Repositories\Contracts\DetalleInmuebleRepositoryInterface;
use App\Repositories\DetalleInmuebleRepository;
use App\Repositories\Contracts\UsuarioRepositoryInterface;
use App\Repositories\UsuarioRepository;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->bind(InmuebleRepositoryInterface::class, InmuebleRepository::class);
        $this->app->bind(MunicipioRepositoryInterface::class, MunicipioRepository::class);
        $this->app->bind(BarrioRepositoryInterface::class, BarrioRepository::class);
        $this->app->bind(TipoInmuebleRepositoryInterface::class, TipoInmuebleRepository::class);
        $this->app->bind(ImagenRepositoryInterface::class, ImagenRepository::class);
        $this->app->bind(DetalleInmuebleRepositoryInterface::class, DetalleInmuebleRepository::class);
        $this->app->bind(UsuarioRepositoryInterface::class, UsuarioRepository::class);
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
