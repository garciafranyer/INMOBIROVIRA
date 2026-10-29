@extends('layouts.empresa')

@section('title', 'Mis Inmuebles')

@section('content')

    {{-- CABECERA BIENVENIDA DE LA EMPRESA --}}
    <div class="mb-6 bg-gradient-to-r from-indigo-900 via-indigo-800 to-slate-900 text-white rounded-2xl p-6 sm:p-8 shadow-lg flex flex-col md:flex-row md:items-center justify-between gap-6">
        <div class="flex items-center gap-4">
            <div class="w-16 h-16 rounded-2xl bg-white/10 backdrop-blur-md border border-white/20 text-white font-black text-2xl flex items-center justify-center shrink-0 shadow-inner">
                {{ strtoupper(substr($usuario->nombre ?? $usuario->name, 0, 2)) }}
            </div>
            <div>
                <span class="text-xs font-bold uppercase tracking-wider text-indigo-300">Bienvenido a tu portal</span>
                <h1 class="text-2xl sm:text-3xl font-black text-white leading-tight">
                    {{ $usuario->nombre ?? $usuario->name }}
                </h1>
                <div class="flex flex-wrap items-center gap-x-4 gap-y-1 text-xs text-indigo-200 mt-1">
                    @if ($usuario->telefono)
                        <span class="flex items-center gap-1">
                            <span>📞</span> {{ $usuario->telefono }}
                        </span>
                    @endif
                    <span class="flex items-center gap-1">
                        <span>✉️</span> {{ $usuario->email }}
                    </span>
                    @if ($usuario->direccion)
                        <span class="flex items-center gap-1">
                            <span>📍</span> {{ $usuario->direccion }}
                        </span>
                    @endif
                </div>
            </div>
        </div>

        <a href="{{ route('empresa.crear') }}"
           class="inline-flex items-center justify-center gap-2 px-6 py-3.5 rounded-xl bg-indigo-500 hover:bg-indigo-600 text-white font-bold text-sm shadow-lg shadow-indigo-500/30 transition transform hover:scale-102 cursor-pointer shrink-0">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
            <span>Publicar nuevo inmueble</span>
        </a>
    </div>

    {{-- TARJETAS ESTADÍSTICAS RÁPIDAS --}}
    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 mb-6">
        <div class="bg-white rounded-xl border border-slate-200 p-5 shadow-xs flex items-center justify-between">
            <div>
                <p class="text-xs font-semibold text-slate-400 uppercase tracking-wider">Total de Inmuebles</p>
                <p class="text-2xl font-black text-slate-800 mt-1">{{ $totalInmuebles }}</p>
            </div>
            <div class="w-11 h-11 rounded-xl bg-indigo-50 text-indigo-600 flex items-center justify-center text-xl">
                🏘️
            </div>
        </div>

        <div class="bg-white rounded-xl border border-slate-200 p-5 shadow-xs flex items-center justify-between">
            <div>
                <p class="text-xs font-semibold text-slate-400 uppercase tracking-wider">Disponibles</p>
                <p class="text-2xl font-black text-emerald-600 mt-1">{{ $disponibles }}</p>
            </div>
            <div class="w-11 h-11 rounded-xl bg-emerald-50 text-emerald-600 flex items-center justify-center text-xl">
                ✅
            </div>
        </div>

        <div class="bg-white rounded-xl border border-slate-200 p-5 shadow-xs flex items-center justify-between">
            <div>
                <p class="text-xs font-semibold text-slate-400 uppercase tracking-wider">Arrendados / Vendidos</p>
                <p class="text-2xl font-black text-slate-700 mt-1">{{ $cerrados }}</p>
            </div>
            <div class="w-11 h-11 rounded-xl bg-slate-100 text-slate-600 flex items-center justify-center text-xl">
                🏷️
            </div>
        </div>
    </div>

    {{-- LISTADO DE INMUEBLES --}}
    <div class="bg-white rounded-2xl border border-slate-200 shadow-xs overflow-hidden">
        <div class="p-5 border-b border-slate-100 flex items-center justify-between">
            <div>
                <h2 class="text-lg font-bold text-slate-900">Mis Inmuebles Publicados</h2>
                <p class="text-xs text-slate-500 mt-0.5">Aquí administras todas las propiedades creadas por tu empresa.</p>
            </div>
            <span class="text-xs font-semibold text-slate-400">
                Mostrando {{ $inmuebles->count() }} de {{ $inmuebles->total() }}
            </span>
        </div>

        @if ($inmuebles->isEmpty())
            <div class="p-12 text-center">
                <div class="w-16 h-16 rounded-2xl bg-indigo-50 text-indigo-600 text-3xl flex items-center justify-center mx-auto mb-3">
                    🏡
                </div>
                <h3 class="text-base font-bold text-slate-800">Aún no has publicado ningún inmueble</h3>
                <p class="text-xs text-slate-500 max-w-sm mx-auto mt-1 mb-5">
                    Comienza a promocionar tus casas, apartamentos, fincas o locales en el portal público de InmobiRovira.
                </p>
                <a href="{{ route('empresa.crear') }}"
                   class="inline-flex items-center gap-2 px-5 py-2.5 rounded-xl bg-indigo-600 hover:bg-indigo-700 text-white font-bold text-sm shadow-md transition">
                    + Publicar mi primer inmueble
                </a>
            </div>
        @else
            <div class="overflow-x-auto">
                <table class="w-full text-left text-sm">
                    <thead class="bg-slate-50 text-xs uppercase font-semibold text-slate-500 border-b border-slate-200">
                        <tr>
                            <th class="px-5 py-3.5">Inmueble</th>
                            <th class="px-5 py-3.5">Ubicación</th>
                            <th class="px-5 py-3.5">Oferta</th>
                            <th class="px-5 py-3.5">Precio</th>
                            <th class="px-5 py-3.5">Estado</th>
                            <th class="px-5 py-3.5 text-right">Acciones</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @foreach ($inmuebles as $inmueble)
                            @php
                                $d = $inmueble->detalle_inmueble;
                                $foto = $inmueble->imagenes->first();
                                $estado = $d?->estado_publicacion ?? 'disponible';
                                $estadoColor = match($estado) {
                                    'disponible' => 'bg-emerald-50 text-emerald-700 border-emerald-200',
                                    'arrendado'  => 'bg-blue-50 text-blue-700 border-blue-200',
                                    'vendido'    => 'bg-purple-50 text-purple-700 border-purple-200',
                                    'reservado'  => 'bg-amber-50 text-amber-700 border-amber-200',
                                    default      => 'bg-slate-100 text-slate-600 border-slate-200',
                                };
                            @endphp
                            <tr class="hover:bg-slate-50/80 transition">
                                {{-- Inmueble con foto --}}
                                <td class="px-5 py-4">
                                    <div class="flex items-center gap-3">
                                        @if ($foto)
                                            <img src="{{ asset('storage/' . $foto->url_imagen) }}"
                                                 alt="{{ $inmueble->nombre }}"
                                                 class="w-14 h-12 rounded-lg object-cover border border-slate-200 shrink-0">
                                        @else
                                            <div class="w-14 h-12 rounded-lg bg-slate-100 text-slate-400 flex items-center justify-center text-xs shrink-0 border border-slate-200">
                                                Sin foto
                                            </div>
                                        @endif
                                        <div class="min-w-0">
                                            <div class="font-bold text-slate-900 truncate max-w-xs">{{ $inmueble->nombre }}</div>
                                            <div class="text-xs text-slate-500">
                                                {{ $inmueble->tipo_inmueble?->nombre ?? 'Inmueble' }}
                                                @if ($d?->area) · {{ $d->area }} m² @endif
                                                @if ($d?->numero_habitacion) · {{ $d->numero_habitacion }} hab @endif
                                            </div>
                                        </div>
                                    </div>
                                </td>

                                {{-- Ubicación --}}
                                <td class="px-5 py-4 text-xs">
                                    <div class="font-semibold text-slate-800">{{ $inmueble->municipio?->nombre ?? 'N/A' }}</div>
                                    <div class="text-slate-400">{{ $inmueble->barrio?->nombre ?? 'Sin barrio' }} · <span class="capitalize">{{ $inmueble->zona }}</span></div>
                                </td>

                                {{-- Oferta --}}
                                <td class="px-5 py-4">
                                    <span class="inline-flex px-2.5 py-1 rounded-full text-xs font-semibold bg-indigo-50 text-indigo-700 border border-indigo-200 capitalize">
                                        {{ $d?->tipo_oferta ?? 'Venta' }}
                                    </span>
                                </td>

                                {{-- Precio --}}
                                <td class="px-5 py-4 font-bold text-slate-900">
                                    ${{ number_format($d?->precio ?? 0, 0, ',', '.') }}
                                </td>

                                {{-- Estado con selector rápido --}}
                                <td class="px-5 py-4">
                                    <form action="{{ route('empresa.estado', $inmueble->id) }}" method="POST">
                                        @csrf
                                        @method('PATCH')
                                        <select name="estado_publicacion"
                                                onchange="this.form.submit()"
                                                class="text-xs font-bold rounded-lg px-2.5 py-1 border {{ $estadoColor }} cursor-pointer focus:outline-none">
                                            <option value="disponible" @selected($estado === 'disponible')>Disponible</option>
                                            <option value="reservado"  @selected($estado === 'reservado')>Reservado</option>
                                            <option value="arrendado"  @selected($estado === 'arrendado')>Arrendado</option>
                                            <option value="vendido"    @selected($estado === 'vendido')>Vendido</option>
                                            <option value="inactivo"   @selected($estado === 'inactivo')>Inactivo</option>
                                        </select>
                                    </form>
                                </td>

                                {{-- Acciones --}}
                                <td class="px-5 py-4 text-right">
                                    <div class="inline-flex items-center gap-1.5">
                                        <a href="{{ route('propiedad.show', $inmueble->id) }}" target="_blank"
                                           class="p-1.5 rounded-lg text-slate-400 hover:text-indigo-600 hover:bg-indigo-50 transition"
                                           title="Ver ficha pública">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                                        </a>

                                        <a href="{{ route('empresa.edit', $inmueble->id) }}"
                                           class="p-1.5 rounded-lg text-slate-400 hover:text-blue-600 hover:bg-blue-50 transition"
                                           title="Editar inmueble">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                                        </a>

                                        <form action="{{ route('empresa.destroy', $inmueble->id) }}" method="POST"
                                              onsubmit="return confirm('¿Estás seguro de eliminar este inmueble?');"
                                              class="inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                    class="p-1.5 rounded-lg text-slate-400 hover:text-rose-600 hover:bg-rose-50 transition cursor-pointer"
                                                    title="Eliminar inmueble">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6M9.5 4h5a1 1 0 011 1v2h-7V5a1 1 0 011-1z"/></svg>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            @if ($inmuebles->hasPages())
                <div class="p-4 border-t border-slate-100">
                    {{ $inmuebles->links() }}
                </div>
            @endif
        @endif
    </div>

@endsection
