<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

// Interfaces
use App\Contracts\CitaServiceInterface;
use App\Contracts\HistoriaClinicaServiceInterface;
use App\Contracts\InsumoServiceInterface;
use App\Contracts\OrdenCompraServiceInterface;
use App\Contracts\PacienteServiceInterface;
use App\Contracts\PedidoServiceInterface;
use App\Contracts\ProcedimientoServiceInterface;
use App\Contracts\ProveedorServiceInterface;
use App\Contracts\RecetaMedicaServiceInterface;
use App\Contracts\RolServiceInterface;
use App\Contracts\UsuarioServiceInterface;

// Implementaciones
use App\Services\CitaService;
use App\Services\HistoriaClinicaService;
use App\Services\InsumoService;
use App\Services\OrdenCompraService;
use App\Services\PacienteService;
use App\Services\PedidoService;
use App\Services\ProcedimientoService;
use App\Services\ProveedorService;
use App\Services\RecetaMedicaService;
use App\Services\RolService;
use App\Services\UsuarioService;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        // Bind de interfaces con sus implementaciones
        $this->app->bind(CitaServiceInterface::class, CitaService::class);
        $this->app->bind(HistoriaClinicaServiceInterface::class, HistoriaClinicaService::class);
        $this->app->bind(InsumoServiceInterface::class, InsumoService::class);
        $this->app->bind(OrdenCompraServiceInterface::class, OrdenCompraService::class);
        $this->app->bind(PacienteServiceInterface::class, PacienteService::class);
        $this->app->bind(PedidoServiceInterface::class, PedidoService::class);
        $this->app->bind(ProcedimientoServiceInterface::class, ProcedimientoService::class);
        $this->app->bind(ProveedorServiceInterface::class, ProveedorService::class);
        $this->app->bind(RecetaMedicaServiceInterface::class, RecetaMedicaService::class);
        $this->app->bind(RolServiceInterface::class, RolService::class);
        $this->app->bind(UsuarioServiceInterface::class, UsuarioService::class);
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
