@extends('layouts.app')

@section('title', 'Dashboard')
@section('page-title', 'Dashboard')

@section('content')

    {{-- MÓDULO DE SEGURIDAD Y ROLES --}}
    <div class="mb-8 bg-white border border-slate-200 rounded-2xl p-6 shadow-sm">
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

    {{-- Tarjetas estadísticas --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-4 gap-4 sm:gap-6">
        <x-stat-card
            label="Total de usuarios"
            :value="number_format($totalUsers)"
            change="+12.4%"
            trend="up"
            icon="users"
        />
        <x-stat-card
            label="Total de productos"
            :value="number_format($totalProducts)"
            change="+4.1%"
            trend="up"
            icon="box"
        />
        <x-stat-card
            label="Ventas del mes"
            :value="number_format($totalSales)"
            change="-2.3%"
            trend="down"
            icon="chart"
        />
        <x-stat-card
            label="Ingresos"
            :value="'$' . number_format($totalRevenue, 2)"
            change="+8.7%"
            trend="up"
            icon="tag"
        />
    </div>

    {{-- Gráficos --}}
    <div class="mt-6 grid grid-cols-1 xl:grid-cols-3 gap-4 sm:gap-6">

        <x-card title="Ventas mensuales" subtitle="Últimos 6 meses" class="xl:col-span-2">
            <canvas id="salesChart" height="110" role="img" aria-label="Gráfico de ventas mensuales"></canvas>
        </x-card>

        <x-card title="Productos por categoría">
            <canvas id="categoryChart" height="200" role="img" aria-label="Gráfico de productos por categoría"></canvas>
        </x-card>
    </div>

    <div class="mt-6 grid grid-cols-1 xl:grid-cols-3 gap-4 sm:gap-6">
        <x-card title="Usuarios registrados" subtitle="Últimos 6 meses" class="xl:col-span-3">
            <canvas id="usersChart" height="90" role="img" aria-label="Gráfico de usuarios registrados"></canvas>
        </x-card>
    </div>

    {{-- Tabla de actividad reciente --}}
    <div class="mt-6">
        <x-card title="Actividad reciente" subtitle="Últimos registros del sistema" :padding="false">
            <x-slot:actions>
                <x-button variant="secondary" href="#">Ver todo</x-button>
            </x-slot:actions>

            <x-table :headers="['Usuario', 'Descripción', 'Estado', 'Fecha', 'Acciones']">
                @forelse ($recentActivity as $item)
                    <tr class="hover:bg-slate-50">
                        <td class="px-5 py-3.5">
                            <div class="flex items-center gap-3">
                                <img
                                    src="{{ $item['avatar'] }}"
                                    class="w-8 h-8 rounded-full object-cover ring-1 ring-slate-100"
                                    alt="Avatar de {{ $item['name'] }}"
                                >
                                <span class="font-medium text-slate-700 whitespace-nowrap">{{ $item['name'] }}</span>
                            </div>
                        </td>
                        <td class="px-5 py-3.5 text-slate-500 max-w-xs truncate">{{ $item['description'] }}</td>
                        <td class="px-5 py-3.5"><x-badge :status="$item['status']" /></td>
                        <td class="px-5 py-3.5 text-slate-500 whitespace-nowrap">{{ $item['date'] }}</td>
                        <td class="px-5 py-3.5">
                            <div class="flex items-center gap-1">
                                <a href="#" class="p-1.5 rounded-lg text-slate-400 hover:bg-slate-100 hover:text-primary-600 focus:outline-none focus:ring-2 focus:ring-primary-500" aria-label="Ver {{ $item['name'] }}">
                                    <span class="w-4 h-4 block">@include('layouts.partials.icons', ['icon' => 'eye'])</span>
                                </a>
                                <a href="#" class="p-1.5 rounded-lg text-slate-400 hover:bg-slate-100 hover:text-primary-600 focus:outline-none focus:ring-2 focus:ring-primary-500" aria-label="Editar {{ $item['name'] }}">
                                    <span class="w-4 h-4 block">@include('layouts.partials.icons', ['icon' => 'pencil'])</span>
                                </a>
                                <button
                                    type="button"
                                    @click="$dispatch('open-modal', 'delete-{{ $loop->index }}')"
                                    class="p-1.5 rounded-lg text-slate-400 hover:bg-red-50 hover:text-red-600 focus:outline-none focus:ring-2 focus:ring-red-500"
                                    aria-label="Eliminar {{ $item['name'] }}"
                                >
                                    <span class="w-4 h-4 block">@include('layouts.partials.icons', ['icon' => 'trash'])</span>
                                </button>

                                <x-modal name="delete-{{ $loop->index }}" title="Eliminar registro" maxWidth="sm">
                                    <p class="text-sm text-slate-500">
                                        ¿Seguro que deseas eliminar a <strong>{{ $item['name'] }}</strong>? Esta acción no se puede deshacer.
                                    </p>
                                    <x-slot:footer>
                                        <x-button variant="secondary" @click="show = false">Cancelar</x-button>
                                        <x-button variant="danger">Eliminar</x-button>
                                    </x-slot:footer>
                                </x-modal>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="px-5 py-10 text-center text-sm text-slate-400">
                            No hay actividad reciente.
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

        new Chart(document.getElementById('salesChart'), {
            type: 'line',
            data: {
                labels: monthLabels,
                datasets: [{
                    label: 'Ventas',
                    data: @json($chartData['sales']),
                    borderColor: '#4f46e5',
                    backgroundColor: 'rgba(79,70,229,0.08)',
                    tension: 0.35,
                    fill: true,
                    pointRadius: 3,
                }]
            },
            options: {
                responsive: true,
                plugins: { legend: { display: false } },
                scales: { y: { beginAtZero: true, grid: { color: '#f1f5f9' } }, x: { grid: { display: false } } }
            }
        });

        new Chart(document.getElementById('usersChart'), {
            type: 'bar',
            data: {
                labels: monthLabels,
                datasets: [{
                    label: 'Usuarios registrados',
                    data: @json($chartData['users']),
                    backgroundColor: '#818cf8',
                    borderRadius: 6,
                    maxBarThickness: 36,
                }]
            },
            options: {
                responsive: true,
                plugins: { legend: { display: false } },
                scales: { y: { beginAtZero: true, grid: { color: '#f1f5f9' } }, x: { grid: { display: false } } }
            }
        });

        new Chart(document.getElementById('categoryChart'), {
            type: 'doughnut',
            data: {
                labels: @json($chartData['categoryLabels']),
                datasets: [{
                    data: @json($chartData['categoryValues']),
                    backgroundColor: ['#4f46e5', '#818cf8', '#c7d2fe', '#a5b4fc', '#312e81'],
                    borderWidth: 0,
                }]
            },
            options: {
                responsive: true,
                plugins: { legend: { position: 'bottom', labels: { boxWidth: 10, padding: 16, font: { size: 11 } } } }
            }
        });
    });
</script>
@endpush
