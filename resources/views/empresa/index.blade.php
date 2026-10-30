@extends('layouts.empresa')

@section('title', 'Mis Inmuebles')

@section('content')

    {{-- CABECERA BIENVENIDA DE LA EMPRESA (Dark Luxury) --}}
    <div class="mb-8 bg-gradient-to-r from-neutral-900 via-neutral-950 to-neutral-900 text-white rounded-3xl p-6 sm:p-8 shadow-2xl border border-neutral-800 flex flex-col md:flex-row md:items-center justify-between gap-6 relative overflow-hidden">
        {{-- Resplandor decorativo azul oscuro en la esquina --}}
        <div class="absolute -right-12 -bottom-12 w-72 h-72 bg-blue-600/10 rounded-full blur-3xl pointer-events-none"></div>

        <div class="flex items-center gap-4 relative z-10">
            <div class="w-16 h-16 rounded-2xl bg-neutral-900 border border-neutral-700/80 text-white font-black text-2xl flex items-center justify-center shrink-0 shadow-xl shadow-black/60">
                <span class="text-blue-400">{{ strtoupper(substr($usuario->nombre ?? $usuario->name, 0, 2)) }}</span>
            </div>
            <div>
                <span class="inline-flex items-center gap-1.5 text-xs font-bold uppercase tracking-wider text-blue-400">
                    <span class="w-2 h-2 rounded-full bg-blue-500 animate-pulse"></span>
                    Portal de Gestión Inmobiliaria
                </span>
                <h1 class="text-2xl sm:text-3xl font-black text-white leading-tight mt-0.5 tracking-tight">
                    {{ $usuario->nombre ?? $usuario->name }}
                </h1>
                <div class="flex flex-wrap items-center gap-x-3 gap-y-1.5 text-xs text-neutral-300 mt-2.5">
                    <span class="inline-flex items-center gap-1.5 bg-neutral-900/90 px-3 py-1.5 rounded-xl border border-neutral-800 shadow-xs">
                        <svg class="w-3.5 h-3.5 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                        <span>{{ $usuario->email }}</span>
                    </span>
                    @if ($usuario->telefono)
                        <span class="inline-flex items-center gap-1.5 bg-neutral-900/90 px-3 py-1.5 rounded-xl border border-neutral-800 shadow-xs">
                            <svg class="w-3.5 h-3.5 text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/></svg>
                            <span>{{ $usuario->telefono }}</span>
                        </span>
                    @endif
                    @if ($usuario->direccion)
                        <span class="inline-flex items-center gap-1.5 bg-neutral-900/90 px-3 py-1.5 rounded-xl border border-neutral-800 shadow-xs">
                            <svg class="w-3.5 h-3.5 text-amber-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                            <span>{{ $usuario->direccion }}</span>
                        </span>
                    @endif
                </div>
            </div>
        </div>

        <a href="{{ route('empresa.crear') }}"
           class="inline-flex items-center justify-center gap-2 px-6 py-3.5 rounded-2xl bg-blue-600 hover:bg-blue-500 text-white font-bold text-sm shadow-xl shadow-blue-600/30 transition transform hover:-translate-y-0.5 cursor-pointer shrink-0 border border-blue-400/30 relative z-10">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"/></svg>
            <span>Publicar nuevo inmueble</span>
        </a>
    </div>

    {{-- TARJETAS ESTADÍSTICAS DARK LUXURY --}}
    <div class="grid grid-cols-1 sm:grid-cols-3 gap-5 mb-8">
        {{-- Total Inmuebles --}}
        <div class="bg-neutral-900/90 rounded-2xl border border-neutral-800 p-5 shadow-lg flex items-center justify-between">
            <div>
                <p class="text-xs font-bold text-neutral-400 uppercase tracking-wider">Total Inmuebles</p>
                <p class="text-3xl font-black text-white mt-1">{{ $totalInmuebles }}</p>
                <p class="text-[11px] text-neutral-500 mt-0.5">Propiedades registradas</p>
            </div>
            <div class="w-12 h-12 rounded-2xl bg-neutral-950 text-blue-400 border border-neutral-800 flex items-center justify-center shrink-0 shadow-inner">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
            </div>
        </div>

        {{-- Disponibles --}}
        <div class="bg-neutral-900/90 rounded-2xl border border-neutral-800 p-5 shadow-lg flex items-center justify-between">
            <div>
                <p class="text-xs font-bold text-emerald-400 uppercase tracking-wider">Disponibles</p>
                <p class="text-3xl font-black text-emerald-400 mt-1">{{ $disponibles }}</p>
                <p class="text-[11px] text-neutral-500 mt-0.5">Visibles en la web</p>
            </div>
            <div class="w-12 h-12 rounded-2xl bg-emerald-950/60 text-emerald-400 border border-emerald-800/80 flex items-center justify-center shrink-0 shadow-inner">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            </div>
        </div>

        {{-- Arrendados / Vendidos --}}
        <div class="bg-neutral-900/90 rounded-2xl border border-neutral-800 p-5 shadow-lg flex items-center justify-between">
            <div>
                <p class="text-xs font-bold text-neutral-400 uppercase tracking-wider">Arrendados / Vendidos</p>
                <p class="text-3xl font-black text-neutral-300 mt-1">{{ $cerrados }}</p>
                <p class="text-[11px] text-neutral-500 mt-0.5">Operaciones cerradas</p>
            </div>
            <div class="w-12 h-12 rounded-2xl bg-neutral-950 text-neutral-400 border border-neutral-800 flex items-center justify-center shrink-0 shadow-inner">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/></svg>
            </div>
        </div>
    </div>

    {{-- LISTADO DE INMUEBLES DARK LUXURY --}}
    <div class="bg-neutral-900/90 rounded-3xl border border-neutral-800 shadow-2xl overflow-hidden backdrop-blur-md">
        <div class="p-5 sm:p-6 border-b border-neutral-800 flex flex-col sm:flex-row sm:items-center justify-between gap-3 bg-neutral-900/50">
            <div>
                <h2 class="text-lg font-bold text-white tracking-tight">Mis Inmuebles Publicados</h2>
                <p class="text-xs text-neutral-400 mt-0.5">Administra, edita o actualiza el estado de las propiedades de tu empresa.</p>
            </div>
            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-neutral-950 text-neutral-300 border border-neutral-800 self-start sm:self-auto">
                Mostrando {{ $inmuebles->count() }} de {{ $inmuebles->total() }} propiedades
            </span>
        </div>

        @if ($inmuebles->isEmpty())
            <div class="p-12 text-center">
                <div class="w-16 h-16 rounded-3xl bg-neutral-950 text-blue-400 flex items-center justify-center mx-auto mb-4 border border-neutral-800 shadow-inner">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg>
                </div>
                <h3 class="text-base font-bold text-white">Aún no has publicado ningún inmueble</h3>
                <p class="text-xs text-neutral-400 max-w-sm mx-auto mt-1 mb-6">
                    Comienza a promocionar tus casas, apartamentos, fincas o locales en el portal oficial de InmobiRovira.
                </p>
                <a href="{{ route('empresa.crear') }}"
                   class="inline-flex items-center gap-2 px-6 py-3 rounded-2xl bg-blue-600 hover:bg-blue-500 text-white font-bold text-sm shadow-xl shadow-blue-600/30 transition cursor-pointer">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"/></svg>
                    <span>Publicar mi primer inmueble</span>
                </a>
            </div>
        @else
            <div class="overflow-x-auto">
                <table class="w-full text-left text-sm">
                    <thead class="bg-neutral-950/80 text-[11px] uppercase font-bold text-neutral-400 border-b border-neutral-800 tracking-wider">
                        <tr>
                            <th class="px-5 py-4">Inmueble</th>
                            <th class="px-5 py-4">Ubicación</th>
                            <th class="px-5 py-4">Oferta</th>
                            <th class="px-5 py-4">Precio</th>
                            <th class="px-5 py-4">Estado</th>
                            <th class="px-5 py-4 text-right">Acciones</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-neutral-800">
                        @foreach ($inmuebles as $inmueble)
                            @php
                                $d = $inmueble->detalle_inmueble;
                                $foto = $inmueble->imagenes->first();
                                $estado = $d?->estado_publicacion ?? 'disponible';
                                $estadoColor = match($estado) {
                                    'disponible' => 'bg-emerald-950/80 text-emerald-300 border-emerald-800',
                                    'reservado'  => 'bg-amber-950/80 text-amber-300 border-amber-800',
                                    'arrendado'  => 'bg-blue-950/80 text-blue-300 border-blue-800',
                                    'vendido'    => 'bg-neutral-800 text-neutral-300 border-neutral-700',
                                    default      => 'bg-rose-950/80 text-rose-300 border-rose-800'
                                };
                                $oferta = strtolower($d?->tipo_oferta ?? 'venta');
                                $ofertaBadge = match($oferta) {
                                    'arriendo' => 'bg-blue-950/80 text-blue-300 border-blue-800/80',
                                    'venta' => 'bg-emerald-950/80 text-emerald-300 border-emerald-800/80',
                                    default => 'bg-purple-950/80 text-purple-300 border-purple-800/80'
                                };
                            @endphp
                            <tr class="hover:bg-neutral-800/40 transition">
                                {{-- Miniatura e información --}}
                                <td class="px-5 py-4">
                                    <div class="flex items-center gap-3">
                                        <div class="w-14 h-14 rounded-2xl bg-neutral-950 overflow-hidden shrink-0 border border-neutral-800 shadow-sm">
                                            @if ($foto)
                                                <img src="{{ asset('storage/' . ($foto->url_imagen ?? $foto->ruta_imagen)) }}"
                                                     alt="{{ $inmueble->nombre }}"
                                                     class="w-full h-full object-cover">
                                            @else
                                                <div class="w-full h-full flex items-center justify-center text-neutral-600 bg-neutral-950">
                                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                                                </div>
                                            @endif
                                        </div>
                                        <div>
                                            <a href="{{ route('propiedad.show', $inmueble->id) }}" target="_blank"
                                               class="font-bold text-white hover:text-blue-400 transition block leading-snug line-clamp-1">
                                                {{ $inmueble->nombre }}
                                            </a>
                                            <div class="flex items-center gap-2 text-xs text-neutral-400 mt-1">
                                                <span class="inline-flex items-center px-2 py-0.5 rounded-md bg-neutral-800 text-neutral-300 font-semibold text-[11px] border border-neutral-700/60">
                                                    {{ $inmueble->tipo_inmueble?->nombre ?? 'Inmueble' }}
                                                </span>
                                                @if ($d?->area)
                                                    <span>{{ $d->area }} m²</span>
                                                @endif
                                                @if ($d?->numero_habitacion)
                                                    <span>• {{ $d->numero_habitacion }} hab</span>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </td>

                                {{-- Ubicación --}}
                                <td class="px-5 py-4 text-xs">
                                    <div class="font-bold text-neutral-200">{{ $inmueble->municipio?->nombre ?? 'N/A' }}</div>
                                    <div class="text-neutral-400 mt-0.5">
                                        {{ $inmueble->barrio?->nombre ?? 'Sin barrio' }} • <span class="capitalize">{{ $inmueble->zona }}</span>
                                    </div>
                                </td>

                                {{-- Oferta --}}
                                <td class="px-5 py-4">
                                    <span class="inline-flex px-2.5 py-1 rounded-full text-xs font-bold border capitalize {{ $ofertaBadge }}">
                                        {{ $d?->tipo_oferta ?? 'Venta' }}
                                    </span>
                                </td>

                                {{-- Precio --}}
                                <td class="px-5 py-4 font-black text-white text-sm">
                                    ${{ number_format($d?->precio ?? 0, 0, ',', '.') }}
                                </td>

                                {{-- Estado con selector rápido --}}
                                <td class="px-5 py-4">
                                    <form action="{{ route('empresa.estado', $inmueble->id) }}" method="POST">
                                        @csrf
                                        @method('PATCH')
                                        <select name="estado_publicacion"
                                                onchange="this.form.submit()"
                                                class="text-xs font-bold rounded-xl px-2.5 py-1.5 border {{ $estadoColor }} cursor-pointer focus:outline-none transition">
                                            <option value="disponible" class="bg-neutral-900 text-emerald-400" @selected($estado === 'disponible')>Disponible</option>
                                            <option value="reservado"  class="bg-neutral-900 text-amber-400" @selected($estado === 'reservado')>Reservado</option>
                                            <option value="arrendado"  class="bg-neutral-900 text-blue-400" @selected($estado === 'arrendado')>Arrendado</option>
                                            <option value="vendido"    class="bg-neutral-900 text-neutral-300" @selected($estado === 'vendido')>Vendido</option>
                                            <option value="inactivo"   class="bg-neutral-900 text-rose-400" @selected($estado === 'inactivo')>Inactivo</option>
                                        </select>
                                    </form>
                                </td>

                                {{-- Acciones --}}
                                <td class="px-5 py-4 text-right">
                                    <div class="inline-flex items-center gap-1">
                                        <a href="{{ route('propiedad.show', $inmueble->id) }}" target="_blank"
                                           class="p-2 rounded-xl text-neutral-400 hover:text-white hover:bg-neutral-800 transition"
                                           title="Ver ficha pública">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                                        </a>

                                        <a href="{{ route('empresa.edit', $inmueble->id) }}"
                                           class="p-2 rounded-xl text-neutral-400 hover:text-blue-400 hover:bg-neutral-800 transition"
                                           title="Editar inmueble">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                                        </a>

                                        <form action="{{ route('empresa.destroy', $inmueble->id) }}" method="POST"
                                              onsubmit="return confirm('¿Estás seguro de que deseas eliminar este inmueble? Esta acción no se puede deshacer.');"
                                              class="inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                    class="p-2 rounded-xl text-neutral-400 hover:text-rose-400 hover:bg-neutral-800 transition cursor-pointer"
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
                <div class="p-4 border-t border-neutral-800 bg-neutral-950/60">
                    {{ $inmuebles->links() }}
                </div>
            @endif
        @endif
    </div>

@endsection
