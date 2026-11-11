@extends('layouts.app')

@section('title', 'Dashboard')
@section('page-title', 'Dashboard')

@section('content')

    {{-- BARRA SUPERIOR DE ACCIONES RÁPIDAS --}}
    <div class="mb-8 flex flex-col sm:flex-row sm:items-center justify-between gap-4 bg-white border border-slate-200 rounded-2xl p-5 sm:p-6 shadow-sm">
        <div>
            <div class="flex items-center gap-2">
                <h1 class="text-2xl font-black text-slate-900 tracking-tight">Panel Inmobiliario</h1>
                <span class="text-xs font-bold px-2.5 py-0.5 rounded-full bg-blue-100 text-blue-700">García Rovira</span>
            </div>
            <p class="text-xs sm:text-sm text-slate-500 mt-1">Métricas en tiempo real, gestión de propiedades y actividad del portal Inmobirovira.</p>
        </div>

        <div class="flex items-center gap-2 flex-wrap">
            <a href="{{ route('inmueble.create') }}" class="inline-flex items-center gap-1.5 px-4 py-2.5 rounded-xl text-xs font-bold bg-blue-600 hover:bg-blue-700 text-white shadow-md shadow-blue-600/30 transition transform hover:scale-102 cursor-pointer">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                <span>Publicar Inmueble</span>
            </a>
            <a href="{{ route('inmueble.index') }}" class="inline-flex items-center gap-1.5 px-3.5 py-2.5 rounded-xl text-xs font-semibold bg-slate-100 hover:bg-slate-200 text-slate-700 border border-slate-200 transition">
                <span>Inventario Completo</span>
            </a>
            <a href="{{ route('inicio') }}" target="_blank" class="inline-flex items-center gap-1.5 px-3.5 py-2.5 rounded-xl text-xs font-semibold bg-slate-100 hover:bg-slate-200 text-slate-700 border border-slate-200 transition">
                <svg class="w-4 h-4 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/></svg>
                <span>Ver Portal Público</span>
            </a>
        </div>
    </div>

    {{-- ALERTA DE AUTORIZACIÓN: INMUEBLES PENDIENTES DE MODERACIÓN --}}
    @if ($totalPendientes > 0)
        <div class="mb-8 p-5 sm:p-6 rounded-2xl bg-gradient-to-r from-amber-500/15 via-amber-500/10 to-transparent border-2 border-amber-400 flex flex-col sm:flex-row sm:items-center justify-between gap-4 shadow-md shadow-amber-500/5">
            <div class="flex items-start sm:items-center gap-3.5">
                <div class="w-12 h-12 rounded-2xl bg-amber-500 text-white flex items-center justify-center shrink-0 shadow-lg shadow-amber-500/30">
                    <svg class="w-6 h-6 animate-pulse" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/>
                    </svg>
                </div>
                <div>
                    <div class="flex items-center gap-2">
                        <h3 class="text-base font-black text-amber-950">
                            {{ $totalPendientes }} {{ $totalPendientes === 1 ? 'Inmueble requiere tu autorización' : 'Inmuebles requieren tu autorización' }}
                        </h3>
                        <span class="px-2 py-0.5 text-[11px] font-black rounded-full bg-amber-500 text-white">Acción requerida</span>
                    </div>
                    <p class="text-xs sm:text-sm text-amber-900 mt-1">
                        Usuarios particulares han publicado propiedades que están en moderación. Revisa sus datos, fotos y precios para decidir si aprobarlos o rechazarlos.
                    </p>
                </div>
            </div>
            <a href="{{ route('inmueble.index') }}"
               class="inline-flex items-center justify-center gap-2 px-5 py-3 rounded-xl text-xs font-bold bg-amber-600 hover:bg-amber-700 text-white shadow-lg shadow-amber-600/30 transition transform hover:scale-102 shrink-0">
                <span>Revisar y Autorizar</span>
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
            </a>
        </div>
    @endif

    {{-- TARJETAS ESTADÍSTICAS REALES DE INMUEBLES --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-4 gap-4 sm:gap-6">
        <x-stat-card
            label="Total de Inmuebles"
            :value="number_format($totalInmuebles)"
            icon="home"
        />
        <x-stat-card
            label="Disponibles en Venta"
            :value="number_format($totalVenta)"
            icon="tag"
        />
        <x-stat-card
            label="Disponibles en Arriendo"
            :value="number_format($totalArriendo)"
            icon="box"
        />
        <x-stat-card
            label="Inmuebles Cerrados (Éxito)"
            :value="number_format($totalCerrados)"
            icon="shield"
        />
    </div>

    {{-- GRÁFICOS INMOBILIARIOS --}}
    <div class="mt-6 grid grid-cols-1 xl:grid-cols-3 gap-4 sm:gap-6">

        {{-- Gráfico 1: Publicaciones en los últimos 6 meses --}}
        <x-card title="Publicaciones mensuales" subtitle="Inmuebles creados en los últimos 6 meses" class="xl:col-span-2">
            <canvas id="salesChart" height="110" role="img" aria-label="Gráfico de publicaciones mensuales"></canvas>
        </x-card>

        {{-- Gráfico 2: Inmuebles por tipo de propiedad --}}
        <x-card title="Inmuebles por Tipo" subtitle="Distribución por categoría">
            <canvas id="categoryChart" height="200" role="img" aria-label="Gráfico de inmuebles por tipo"></canvas>
        </x-card>
    </div>

    {{-- Gráfico 3: Cobertura por Municipio --}}
    <div class="mt-6 grid grid-cols-1 xl:grid-cols-3 gap-4 sm:gap-6">
        <x-card title="Inmuebles por Municipio" subtitle="Presencia en la provincia de García Rovira" class="xl:col-span-3">
            <canvas id="usersChart" height="90" role="img" aria-label="Gráfico de inmuebles por municipio"></canvas>
        </x-card>
    </div>

    {{-- MÓDULO DE SEGURIDAD Y ROLES --}}
    <div class="mt-8 mb-8 bg-white border border-slate-200 rounded-2xl p-6 shadow-sm">
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3 mb-6 pb-4 border-b border-slate-100">
            <div>
                <div class="flex items-center gap-2">
                    <span class="p-2 rounded-xl bg-indigo-50 text-indigo-600">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5-1a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </span>
                    <h2 class="text-xl font-bold text-slate-900 tracking-tight">Seguridad y Roles</h2>
                </div>
                <p class="text-sm text-slate-500 mt-1">Administración de perfiles, permisos por módulo y cuentas de acceso al sistema.</p>
            </div>
            <span class="inline-flex items-center gap-1.5 text-xs font-semibold px-3 py-1 rounded-full bg-indigo-50 text-indigo-700 border border-indigo-200 w-fit">
                <span class="w-2 h-2 rounded-full bg-indigo-600 animate-pulse"></span>
                Panel Activo
            </span>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">

            {{-- 1. Roles --}}
            <a href="{{ route('seguridad.roles.index') }}"
               class="group p-5 bg-slate-50 hover:bg-white rounded-xl border border-slate-200 hover:border-indigo-500 hover:shadow-lg transition-all duration-200 flex flex-col justify-between">
                <div>
                    <div class="flex items-center justify-between mb-3">
                        <div class="w-10 h-10 rounded-xl bg-indigo-600 text-white flex items-center justify-center shadow-md shadow-indigo-600/30 group-hover:scale-110 transition-transform">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15 19.128a9.38 9.38 0 002.625.372 9.337 9.337 0 004.121-.952 4.125 4.125 0 00-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 018.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0111.964-3.07M12 6.375a3.375 3.375 0 11-6.75 0 3.375 3.375 0 016.75 0zm8.25 2.25a2.625 2.625 0 11-5.25 0 2.625 2.625 0 015.25 0z" />
                            </svg>
                        </div>
                        <span class="text-[11px] font-bold uppercase tracking-wider text-slate-400">01</span>
                    </div>
                    <span class="text-xs font-semibold text-indigo-600 block mb-0.5">Para ver y crear</span>
                    <h3 class="font-bold text-slate-900 text-base group-hover:text-indigo-600 transition">Roles</h3>
                    <p class="text-xs text-slate-500 mt-1.5 leading-relaxed">Configura perfiles como Administrador, Agente, Secretaria, etc.</p>
                </div>
                <div class="mt-4 pt-3 border-t border-slate-200/80 flex items-center justify-between text-xs font-bold text-indigo-600 group-hover:translate-x-0.5 transition-transform">
                    <span>Gestionar Roles</span>
                    <span>&rarr;</span>
                </div>
            </a>

            {{-- 2. Permisos --}}
            <a href="{{ route('seguridad.permisos.index') }}"
               class="group p-5 bg-slate-50 hover:bg-white rounded-xl border border-slate-200 hover:border-emerald-500 hover:shadow-lg transition-all duration-200 flex flex-col justify-between">
                <div>
                    <div class="flex items-center justify-between mb-3">
                        <div class="w-10 h-10 rounded-xl bg-emerald-600 text-white flex items-center justify-center shadow-md shadow-emerald-600/30 group-hover:scale-110 transition-transform">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75m-3-7.036A11.959 11.959 0 013.598 6 11.99 11.99 0 003 9.749c0 5.592 3.824 10.29 9 11.623 5.176-1.332 9-6.03 9-11.622 0-1.31-.21-2.571-.598-3.751h-.152c-3.196 0-6.1-1.248-8.25-3.285z" />
                            </svg>
                        </div>
                        <span class="text-[11px] font-bold uppercase tracking-wider text-slate-400">02</span>
                    </div>
                    <span class="text-xs font-semibold text-emerald-600 block mb-0.5">Para ver y crear</span>
                    <h3 class="font-bold text-slate-900 text-base group-hover:text-emerald-600 transition">Permisos</h3>
                    <p class="text-xs text-slate-500 mt-1.5 leading-relaxed">Crea módulos y permisos (ver, crear, editar, eliminar).</p>
                </div>
                <div class="mt-4 pt-3 border-t border-slate-200/80 flex items-center justify-between text-xs font-bold text-emerald-600 group-hover:translate-x-0.5 transition-transform">
                    <span>Gestionar Permisos</span>
                    <span>&rarr;</span>
                </div>
            </a>

            {{-- 3. Cuentas de usuario --}}
            <a href="{{ route('seguridad.cuentas.index') }}"
               class="group p-5 bg-slate-50 hover:bg-white rounded-xl border border-slate-200 hover:border-blue-500 hover:shadow-lg transition-all duration-200 flex flex-col justify-between">
                <div>
                    <div class="flex items-center justify-between mb-3">
                        <div class="w-10 h-10 rounded-xl bg-blue-600 text-white flex items-center justify-center shadow-md shadow-blue-600/30 group-hover:scale-110 transition-transform">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632z" />
                            </svg>
                        </div>
                        <span class="text-[11px] font-bold uppercase tracking-wider text-slate-400">03</span>
                    </div>
                    <span class="text-xs font-semibold text-blue-600 block mb-0.5">Para gestionar</span>
                    <h3 class="font-bold text-slate-900 text-base group-hover:text-blue-600 transition">Cuentas de usuario</h3>
                    <p class="text-xs text-slate-500 mt-1.5 leading-relaxed">Crea credenciales con correo, contraseña y rol asignado.</p>
                </div>
                <div class="mt-4 pt-3 border-t border-slate-200/80 flex items-center justify-between text-xs font-bold text-blue-600 group-hover:translate-x-0.5 transition-transform">
                    <span>Gestionar Cuentas</span>
                    <span>&rarr;</span>
                </div>
            </a>

            {{-- 4. Asignar roles a los usuarios --}}
            <a href="{{ route('seguridad.usuarios.index') }}"
               class="group p-5 bg-slate-50 hover:bg-white rounded-xl border border-slate-200 hover:border-purple-500 hover:shadow-lg transition-all duration-200 flex flex-col justify-between">
                <div>
                    <div class="flex items-center justify-between mb-3">
                        <div class="w-10 h-10 rounded-xl bg-purple-600 text-white flex items-center justify-center shadow-md shadow-purple-600/30 group-hover:scale-110 transition-transform">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M18 18.72a9.094 9.094 0 003.741-.479 3 3 0 00-4.682-2.72m.94 3.198l.001.031c0 .225-.012.447-.037.666A11.944 11.944 0 0112 21c-2.17 0-4.207-.576-5.963-1.584A6.062 6.062 0 016 18.715m12 0v-.503a3.333 3.333 0 00-3-3.333h-6c-1.657 0-3 1.492-3 3.333v.503m6-9.5a3 3 0 11-6 0 3 3 0 016 0z" />
                            </svg>
                        </div>
                        <span class="text-[11px] font-bold uppercase tracking-wider text-slate-400">04</span>
                    </div>
                    <span class="text-xs font-semibold text-purple-600 block mb-0.5">Para asignar roles a</span>
                    <h3 class="font-bold text-slate-900 text-base group-hover:text-purple-600 transition">Usuarios y Roles</h3>
                    <p class="text-xs text-slate-500 mt-1.5 leading-relaxed">Asigna o cambia el rol de cualquier usuario registrado.</p>
                </div>
                <div class="mt-4 pt-3 border-t border-slate-200/80 flex items-center justify-between text-xs font-bold text-purple-600 group-hover:translate-x-0.5 transition-transform">
                    <span>Asignar Roles</span>
                    <span>&rarr;</span>
                </div>
            </a>

        </div>
    </div>

    {{-- TABLA DE INMUEBLES RECIENTES --}}
    <div class="mt-6">
        <x-card title="Inmuebles Recientes" subtitle="Últimas propiedades registradas o actualizadas" :padding="false">
            <x-slot:actions>
                <x-button variant="secondary" href="{{ route('inmueble.index') }}">Ver inventario completo</x-button>
            </x-slot:actions>

            <x-table :headers="['Inmueble', 'Municipio', 'Oferta y Precio', 'Publicado por', 'Estado', 'Acciones']">
                @forelse ($inmueblesRecientes as $inmueble)
                    @php
                        $det = $inmueble->detalle_inmueble;
                        $primeraFoto = $inmueble->imagenes->first()?->url_imagen;
                    @endphp
                    <tr class="hover:bg-slate-50 transition">
                        <td class="px-5 py-3.5">
                            <div class="flex items-center gap-3">
                                @if($primeraFoto)
                                    <img src="{{ asset('storage/' . $primeraFoto) }}" class="w-10 h-10 rounded-lg object-cover ring-1 ring-slate-200 shrink-0" alt="{{ $inmueble->nombre }}">
                                @else
                                    <div class="w-10 h-10 rounded-lg bg-slate-100 text-slate-400 flex items-center justify-center text-xs shrink-0 font-bold">
                                        🏡
                                    </div>
                                @endif
                                <div>
                                    <span class="font-bold text-slate-800 block text-sm">{{ $inmueble->nombre }}</span>
                                    <span class="text-xs text-slate-400">{{ $inmueble->tipo_inmueble?->nombre ?? 'Inmueble' }} &bull; Zona {{ ucfirst($inmueble->zona) }}</span>
                                </div>
                            </div>
                        </td>
                        <td class="px-5 py-3.5 text-slate-600 text-sm">
                            <div class="font-medium text-slate-700">{{ $inmueble->municipio?->nombre ?? '-' }}</div>
                            <div class="text-xs text-slate-400">{{ $inmueble->barrio?->nombre ? 'B. ' . $inmueble->barrio->nombre : ($det?->direccion ?? '-') }}</div>
                        </td>
                        <td class="px-5 py-3.5">
                            <span class="inline-block text-[11px] font-bold uppercase tracking-wider text-indigo-700 bg-indigo-50 px-2 py-0.5 rounded-full mb-0.5">
                                {{ ucfirst($det?->tipo_oferta ?? 'Oferta') }}
                            </span>
                            <div class="font-bold text-slate-800 text-sm">
                                ${{ number_format($det?->precio ?? 0, 0, ',', '.') }}
                            </div>
                        </td>
                        <td class="px-5 py-3.5 text-slate-600 text-xs">
                            <span class="font-semibold text-slate-700 block">{{ $inmueble->usuario?->nombre ?? 'Administrador' }}</span>
                            <span class="text-slate-400">{{ $inmueble->usuario?->correo ?? '' }}</span>
                        </td>
                        <td class="px-5 py-3.5">
                            @php
                                $estado = strtolower($det?->estado_publicacion ?? 'disponible');
                                $claseBadge = match($estado) {
                                    'disponible' => 'bg-emerald-100 text-emerald-800 border-emerald-200',
                                    'pendiente'  => 'bg-amber-100 text-amber-900 border-amber-300 font-black',
                                    'arrendado'  => 'bg-blue-100 text-blue-800 border-blue-200',
                                    'vendido'    => 'bg-purple-100 text-purple-800 border-purple-200',
                                    'reservado'  => 'bg-amber-100 text-amber-800 border-amber-200',
                                    default      => 'bg-slate-100 text-slate-700 border-slate-200',
                                };
                            @endphp
                            <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-bold border {{ $claseBadge }}">
                                {{ ucfirst($estado) }}
                            </span>
                        </td>
                        <td class="px-5 py-3.5">
                            <div class="flex items-center gap-1">
                                <a href="{{ route('propiedad.show', $inmueble->id) }}" target="_blank" class="p-1.5 rounded-lg text-slate-400 hover:bg-slate-100 hover:text-blue-600 transition" title="Ver en portal público">
                                    <span class="w-4 h-4 block">@include('layouts.partials.icons', ['icon' => 'eye'])</span>
                                </a>
                                <a href="{{ route('inmueble.edit', $inmueble->id) }}" class="p-1.5 rounded-lg text-slate-400 hover:bg-slate-100 hover:text-indigo-600 transition" title="Editar inmueble">
                                    <span class="w-4 h-4 block">@include('layouts.partials.icons', ['icon' => 'pencil'])</span>
                                </a>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="px-5 py-10 text-center text-sm text-slate-400">
                            No hay inmuebles registrados aún. ¡Pulsa en "Publicar Inmueble" para comenzar!
                        </td>
                    </tr>
                @endforelse
            </x-table>
        </x-card>
    </div>

@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const monthLabels = @json($chartData['months']);

        // Gráfico 1: Publicaciones en los últimos 6 meses (Curva azul índigo)
        new Chart(document.getElementById('salesChart'), {
            type: 'line',
            data: {
                labels: monthLabels,
                datasets: [{
                    label: 'Inmuebles publicados',
                    data: @json($chartData['publicaciones']),
                    borderColor: '#2563eb',
                    backgroundColor: 'rgba(37, 99, 235, 0.08)',
                    tension: 0.35,
                    fill: true,
                    pointRadius: 4,
                    pointBackgroundColor: '#2563eb',
                }]
            },
            options: {
                responsive: true,
                plugins: { legend: { display: false } },
                scales: { 
                    y: { 
                        beginAtZero: true, 
                        ticks: { stepSize: 1 },
                        grid: { color: '#f1f5f9' } 
                    }, 
                    x: { grid: { display: false } } 
                }
            }
        });

        // Gráfico 2: Inmuebles por Tipo (Dona colorida)
        new Chart(document.getElementById('categoryChart'), {
            type: 'doughnut',
            data: {
                labels: @json($chartData['tipoLabels']),
                datasets: [{
                    data: @json($chartData['tipoValues']),
                    backgroundColor: ['#2563eb', '#10b981', '#f59e0b', '#8b5cf6', '#ec4899', '#06b6d4'],
                    borderWidth: 0,
                }]
            },
            options: {
                responsive: true,
                plugins: { 
                    legend: { 
                        position: 'bottom', 
                        labels: { boxWidth: 10, padding: 14, font: { size: 11, weight: 'bold' } } 
                    } 
                }
            }
        });

        // Gráfico 3: Cobertura por Municipio (Barras)
        new Chart(document.getElementById('usersChart'), {
            type: 'bar',
            data: {
                labels: @json($chartData['municipioLabels']),
                datasets: [{
                    label: 'Cantidad de Inmuebles',
                    data: @json($chartData['municipioValues']),
                    backgroundColor: '#4f46e5',
                    borderRadius: 8,
                    maxBarThickness: 42,
                }]
            },
            options: {
                responsive: true,
                plugins: { legend: { display: false } },
                scales: { 
                    y: { 
                        beginAtZero: true, 
                        ticks: { stepSize: 1 },
                        grid: { color: '#f1f5f9' } 
                    }, 
                    x: { grid: { display: false } } 
                }
            }
        });
    });
</script>
@endpush
