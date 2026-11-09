<?php

namespace App\Http\Controllers;

use App\Models\Inmueble;
use App\Models\municipio;
use App\Models\tipo_inmueble;
use App\Models\usuario;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    /**
     * Muestra el dashboard principal inmobiliario para administradores.
     */
    public function index(Request $request)
    {
        $usuario = $request->user();
        if ($usuario && ! $usuario->hasRole(config('seguridad.rol_admin', 'administrador'))) {
            return redirect()->route('empresa.index');
        }

        // 1. Métricas Clave Reales de Inmuebles
        $totalInmuebles = Inmueble::count();

        $totalDisponibles = Inmueble::whereHas('detalle_inmueble', function ($q) {
            $q->where('estado_publicacion', 'disponible');
        })->count();

        $totalVenta = Inmueble::whereHas('detalle_inmueble', function ($q) {
            $q->where('estado_publicacion', 'disponible')
              ->where(function ($sub) {
                  $sub->where('tipo_oferta', 'venta')
                      ->orWhere('tipo_oferta', 'venta y arriendo');
              });
        })->count();

        $totalArriendo = Inmueble::whereHas('detalle_inmueble', function ($q) {
            $q->where('estado_publicacion', 'disponible')
              ->where(function ($sub) {
                  $sub->where('tipo_oferta', 'arriendo')
                      ->orWhere('tipo_oferta', 'venta y arriendo');
              });
        })->count();

        $totalCerrados = Inmueble::whereHas('detalle_inmueble', function ($q) {
            $q->whereIn('estado_publicacion', ['arrendado', 'vendido']);
        })->count();

        $totalEmpresas = usuario::whereHas('roles', function ($q) {
            $q->where('name', '!=', config('seguridad.rol_admin', 'administrador'));
        })->count();

        // 2. Gráfico: Inmuebles por Tipo de Inmueble (Casa, Apto, Finca, Lote, etc.)
        $tipos = tipo_inmueble::withCount('inmueble')->get();
        $tipoLabels = $tipos->pluck('nombre')->toArray();
        $tipoValues = $tipos->pluck('inmueble_count')->toArray();

        // 3. Gráfico: Inmuebles por Municipio
        $municipios = municipio::withCount('inmueble')
            ->orderByDesc('inmueble_count')
            ->take(6)
            ->get();
        $municipioLabels = $municipios->pluck('nombre')->toArray();
        $municipioValues = $municipios->pluck('inmueble_count')->toArray();

        // 4. Gráfico: Tendencia últimos 6 meses
        $meses = [];
        $publicacionesPorMes = [];
        for ($i = 5; $i >= 0; $i--) {
            $fecha = now()->subMonths($i);
            $meses[] = ucfirst($fecha->locale('es')->isoFormat('MMM'));
            $publicacionesPorMes[] = Inmueble::whereYear('created_at', $fecha->year)
                ->whereMonth('created_at', $fecha->month)
                ->count();
        }

        // 5. Inmuebles recientes con relaciones
        $inmueblesRecientes = Inmueble::with(['tipo_inmueble', 'municipio', 'barrio', 'detalle_inmueble', 'imagenes', 'usuario'])
            ->latest('updated_at')
            ->take(5)
            ->get();

        $chartData = [
            'months'          => $meses,
            'publicaciones'   => $publicacionesPorMes,
            'municipioLabels' => $municipioLabels,
            'municipioValues' => $municipioValues,
            'tipoLabels'      => $tipoLabels,
            'tipoValues'      => $tipoValues,
        ];

        return view('dashboard.index', compact(
            'totalInmuebles',
            'totalDisponibles',
            'totalVenta',
            'totalArriendo',
            'totalCerrados',
            'totalEmpresas',
            'inmueblesRecientes',
            'chartData'
        ));
    }
}
