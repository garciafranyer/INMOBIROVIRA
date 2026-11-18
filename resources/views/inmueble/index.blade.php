@extends('layouts.app')

@section('title', 'Inventario de Inmuebles')
@section('page-title', 'Inventario de Inmuebles')

@section('content')

@php
    $totalCount = $inmueble->count();
    $pendientesCount = $inmueble->filter(fn($i) => ($i->detalle_inmueble?->estado_publicacion ?? '') === 'pendiente')->count();
    $disponiblesCount = $inmueble->filter(fn($i) => ($i->detalle_inmueble?->estado_publicacion ?? '') === 'disponible')->count();
    $cerradosCount = $inmueble->filter(fn($i) => in_array($i->detalle_inmueble?->estado_publicacion ?? '', ['arrendado', 'vendido']))->count();

    $badge = fn ($estado) => match ($estado) {
        'disponible' => 'bg-emerald-100 text-emerald-800 border-emerald-300 font-bold',
        'arrendado'  => 'bg-blue-100 text-blue-800 border-blue-300 font-bold',
        'vendido'    => 'bg-purple-100 text-purple-800 border-purple-300 font-bold',
        'reservado'  => 'bg-amber-100 text-amber-800 border-amber-300 font-bold',
        'pendiente'  => 'bg-amber-500/20 text-amber-900 border-amber-400 font-black',
        default      => 'bg-slate-100 text-slate-700 border-slate-300 font-semibold',
    };
@endphp

<div x-data="{ tabFiltro: 'todos', buscarTexto: '' }" class="space-y-6">

    {{-- BARRA SUPERIOR DE ACCIONES & TÍTULO --}}
    <div class="bg-white border border-slate-200/90 rounded-3xl p-5 sm:p-6 shadow-xs flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <div class="flex items-center gap-2.5">
                <div class="w-10 h-10 rounded-2xl bg-blue-600/10 text-blue-600 flex items-center justify-center font-bold">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg>
                </div>
                <div>
                    <h2 class="text-xl sm:text-2xl font-black text-slate-900 tracking-tight">Inventario de Inmuebles</h2>
                    <p class="text-xs text-slate-500 mt-0.5">Gestión de publicaciones, moderación y control en García Rovira.</p>
                </div>
            </div>
        </div>

        <div class="flex items-center gap-2.5 flex-wrap">
            <a href="{{ route('inmueble.create') }}"
               class="inline-flex items-center gap-2 bg-blue-600 hover:bg-blue-700 text-white font-bold text-xs px-4 py-3 rounded-2xl shadow-md shadow-blue-600/30 transition transform hover:-translate-y-0.5 cursor-pointer">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"/></svg>
                <span>Publicar Inmueble</span>
            </a>
            <a href="{{ route('inicio') }}"
               class="inline-flex items-center gap-1.5 px-3.5 py-3 rounded-2xl text-xs font-bold bg-slate-100 hover:bg-slate-200 text-slate-700 border border-slate-200 transition">
                <svg class="w-4 h-4 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/></svg>
                <span>Ver Portal Web</span>
            </a>
        </div>
    </div>

    {{-- ALERTA SI HAY INMUEBLES PENDIENTES DE MODERACIÓN --}}
    @if ($pendientesCount > 0)
        <div class="p-4 sm:p-5 rounded-2xl bg-gradient-to-r from-amber-500/15 via-amber-500/10 to-transparent border-2 border-amber-400 flex flex-col sm:flex-row sm:items-center justify-between gap-3 shadow-sm">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-xl bg-amber-500 text-white flex items-center justify-center shrink-0 shadow-md shadow-amber-500/30">
                    <svg class="w-5 h-5 animate-pulse" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
                </div>
                <div>
                    <h4 class="text-xs sm:text-sm font-black text-amber-950">
                        {{ $pendientesCount }} {{ $pendientesCount === 1 ? 'inmueble requiere' : 'inmuebles requieren' }} tu autorización
                    </h4>
                    <p class="text-[11px] sm:text-xs text-amber-900 mt-0.5">
                        Usuarios particulares registraron propiedades que no serán públicas hasta que las autorices con el botón <strong>Aprobar</strong>.
                    </p>
                </div>
            </div>
            <button @click="tabFiltro = 'pendiente'"
                    type="button"
                    class="px-4 py-2 rounded-xl text-xs font-bold bg-amber-600 hover:bg-amber-700 text-white shadow-md shadow-amber-600/30 transition shrink-0 cursor-pointer">
                Filtrar solo pendientes &rarr;
            </button>
        </div>
    @endif

    {{-- PESTAÑAS DE FILTRADO Y BUSCADOR EN VIVO --}}
    <div class="bg-white border border-slate-200/90 rounded-3xl p-4 shadow-xs flex flex-col md:flex-row md:items-center justify-between gap-4">
        {{-- Tabs --}}
        <div class="flex items-center gap-2 overflow-x-auto pb-1 md:pb-0 scrollbar-none">
            <button
                @click="tabFiltro = 'todos'"
                type="button"
                :class="tabFiltro === 'todos' ? 'bg-slate-900 text-white shadow-sm' : 'bg-slate-100 hover:bg-slate-200 text-slate-600'"
                class="px-3.5 py-2 rounded-xl text-xs font-bold transition flex items-center gap-1.5 shrink-0 cursor-pointer"
            >
                <span>Todos</span>
                <span class="px-1.5 py-0.2 rounded-full text-[10px]" :class="tabFiltro === 'todos' ? 'bg-slate-800 text-slate-200' : 'bg-slate-200 text-slate-700'">{{ $totalCount }}</span>
            </button>

            <button
                @click="tabFiltro = 'pendiente'"
                type="button"
                :class="tabFiltro === 'pendiente' ? 'bg-amber-500 text-white shadow-md shadow-amber-500/30' : 'bg-amber-50 hover:bg-amber-100 text-amber-800 border border-amber-200'"
                class="px-3.5 py-2 rounded-xl text-xs font-bold transition flex items-center gap-1.5 shrink-0 cursor-pointer"
            >
                <span>⏳ Pendientes</span>
                <span class="px-1.5 py-0.2 rounded-full text-[10px]" :class="tabFiltro === 'pendiente' ? 'bg-amber-600 text-white' : 'bg-amber-200 text-amber-900'">{{ $pendientesCount }}</span>
            </button>

            <button
                @click="tabFiltro = 'disponible'"
                type="button"
                :class="tabFiltro === 'disponible' ? 'bg-emerald-600 text-white shadow-md shadow-emerald-600/30' : 'bg-emerald-50 hover:bg-emerald-100 text-emerald-800 border border-emerald-200'"
                class="px-3.5 py-2 rounded-xl text-xs font-bold transition flex items-center gap-1.5 shrink-0 cursor-pointer"
            >
                <span>🟢 Disponibles</span>
                <span class="px-1.5 py-0.2 rounded-full text-[10px]" :class="tabFiltro === 'disponible' ? 'bg-emerald-700 text-white' : 'bg-emerald-200 text-emerald-900'">{{ $disponiblesCount }}</span>
            </button>

            <button
                @click="tabFiltro = 'cerrados'"
                type="button"
                :class="tabFiltro === 'cerrados' ? 'bg-blue-600 text-white shadow-md shadow-blue-600/30' : 'bg-slate-100 hover:bg-slate-200 text-slate-600'"
                class="px-3.5 py-2 rounded-xl text-xs font-bold transition flex items-center gap-1.5 shrink-0 cursor-pointer"
            >
                <span>🔵 Cerrados</span>
                <span class="px-1.5 py-0.2 rounded-full text-[10px]" :class="tabFiltro === 'cerrados' ? 'bg-blue-700 text-white' : 'bg-slate-200 text-slate-700'">{{ $cerradosCount }}</span>
            </button>
        </div>

        {{-- Buscador reactivo por texto --}}
        <div class="relative w-full md:w-72">
            <span class="absolute inset-y-0 left-0 flex items-center pl-3.5 text-slate-400 pointer-events-none">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-4.35-4.35M17 10.5a6.5 6.5 0 11-13 0 6.5 6.5 0 0113 0z"/></svg>
            </span>
            <input
                type="text"
                x-model="buscarTexto"
                placeholder="Filtrar por nombre, municipio..."
                class="w-full pl-9 pr-3.5 py-2 text-xs font-semibold rounded-xl border border-slate-200 bg-slate-50 focus:bg-white focus:outline-none focus:ring-2 focus:ring-blue-500 transition"
            >
        </div>
    </div>

    {{-- TABLA PRINCIPAL DE INMUEBLES --}}
    <div class="bg-white border border-slate-200/90 rounded-3xl shadow-xs overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs">
                <thead class="bg-slate-50 text-[11px] uppercase font-bold text-slate-500 border-b border-slate-200 tracking-wider">
                    <tr>
                        <th class="px-5 py-4">Inmueble</th>
                        <th class="px-5 py-4">Ubicación</th>
                        <th class="px-5 py-4">Oferta & Precio</th>
                        <th class="px-5 py-4">Publicado por</th>
                        <th class="px-5 py-4">Estado & Moderación</th>
                        <th class="px-5 py-4 text-right">Acciones</th>
                    </tr>
                </thead>

                <tbody class="divide-y divide-slate-100">
                    @forelse ($inmueble as $item)
                        @php
                            $d = $item->detalle_inmueble;
                            $foto = $item->imagenes->first();
                            $estado = $d?->estado_publicacion ?? 'disponible';
                            $esCerrado = in_array($estado, ['arrendado', 'vendido']);
                            $esParticular = $item->usuario && !$item->usuario->hasRole(config('seguridad.rol_admin', 'administrador')) && !$item->usuario->hasRole('Empresa');
                        @endphp

                        <tr
                            x-show="(
                                (tabFiltro === 'todos') ||
                                (tabFiltro === 'pendiente' && '{{ $estado }}' === 'pendiente') ||
                                (tabFiltro === 'disponible' && '{{ $estado }}' === 'disponible') ||
                                (tabFiltro === 'cerrados' && ({{ $esCerrado ? 'true' : 'false' }}))
                            ) && (
                                !buscarTexto ||
                                '{{ strtolower($item->nombre) }}'.includes(buscarTexto.toLowerCase()) ||
                                '{{ strtolower($item->municipio?->nombre ?? '') }}'.includes(buscarTexto.toLowerCase()) ||
                                '{{ strtolower($item->barrio?->nombre ?? '') }}'.includes(buscarTexto.toLowerCase()) ||
                                '{{ strtolower($item->usuario?->nombre ?? '') }}'.includes(buscarTexto.toLowerCase())
                            )"
                            class="hover:bg-slate-50/80 transition"
                        >
                            {{-- Columna 1: Miniatura & Datos Principales --}}
                            <td class="px-5 py-4">
                                <div class="flex items-center gap-3">
                                    <div class="relative w-14 h-14 rounded-2xl bg-slate-100 overflow-hidden shrink-0 border border-slate-200 shadow-xs">
                                        @if ($foto)
                                            <img src="{{ asset('storage/' . ($foto->url_imagen ?? $foto->ruta_imagen)) }}"
                                                alt="{{ $item->nombre }}"
                                                class="w-full h-full object-cover">
                                        @else
                                            <div class="w-full h-full flex items-center justify-center text-slate-400 bg-slate-100 font-bold text-xs">
                                                🏡
                                            </div>
                                        @endif
                                        @if ($item->imagenes->count() > 1)
                                            <span class="absolute bottom-1 right-1 px-1 py-0.2 bg-black/70 text-white rounded text-[9px] font-bold">
                                                +{{ $item->imagenes->count() - 1 }}
                                            </span>
                                        @endif
                                    </div>
                                    <div class="min-w-0">
                                        <div class="flex items-center gap-1.5 flex-wrap">
                                            <span class="text-[10px] font-black uppercase tracking-wider px-2 py-0.5 rounded-md bg-slate-100 text-slate-600 border border-slate-200">
                                                #{{ $item->id }}
                                            </span>
                                            <span class="text-[10px] font-bold px-2 py-0.5 rounded-md {{ $item->zona === 'urbana' ? 'bg-sky-50 text-sky-700 border border-sky-200' : 'bg-emerald-50 text-emerald-700 border border-emerald-200' }}">
                                                {{ ucfirst($item->zona) }}
                                            </span>
                                            <span class="text-[10px] font-semibold text-slate-400">
                                                {{ $item->tipo_inmueble?->nombre ?? 'Inmueble' }}
                                            </span>
                                        </div>
                                        <span class="font-bold text-slate-900 block text-sm mt-1 truncate hover:text-blue-600 transition" title="{{ $item->nombre }}">
                                            {{ $item->nombre }}
                                        </span>
                                    </div>
                                </div>
                            </td>

                            {{-- Columna 2: Ubicación --}}
                            <td class="px-5 py-4">
                                <div class="font-bold text-slate-800">{{ $item->municipio?->nombre ?? 'Sin municipio' }}</div>
                                <div class="text-slate-400 text-[11px] mt-0.5">
                                    @if ($item->barrio)
                                        {{ $item->zona === 'rural' ? 'Vda. ' : 'B. ' }}{{ $item->barrio->nombre }}
                                    @else
                                        <span class="italic text-slate-400">Sin barrio/vereda</span>
                                    @endif
                                </div>
                            </td>

                            {{-- Columna 3: Oferta & Precio --}}
                            <td class="px-5 py-4">
                                <span class="inline-block px-2 py-0.5 rounded-full text-[10px] font-bold uppercase tracking-wider {{ strtolower($d?->tipo_oferta ?? '') === 'arriendo' ? 'bg-blue-100 text-blue-800' : 'bg-emerald-100 text-emerald-800' }}">
                                    {{ ucfirst($d?->tipo_oferta ?? 'Venta') }}
                                </span>
                                <div class="font-black text-slate-900 text-sm mt-0.5">
                                    ${{ number_format($d?->precio ?? 0, 0, ',', '.') }}
                                </div>
                            </td>

                            {{-- Columna 4: Publicado por --}}
                            <td class="px-5 py-4">
                                <div class="font-bold text-slate-800 truncate max-w-[150px]">{{ $item->usuario?->nombre ?? 'Sistema' }}</div>
                                <div class="mt-0.5">
                                    @if ($esParticular)
                                        <span class="inline-flex items-center px-1.5 py-0.5 rounded text-[10px] font-bold bg-amber-100 text-amber-800">
                                            Propietario
                                        </span>
                                    @elseif ($item->usuario?->hasRole('Empresa'))
                                        <span class="inline-flex items-center px-1.5 py-0.5 rounded text-[10px] font-bold bg-indigo-100 text-indigo-800">
                                            Inmobiliaria
                                        </span>
                                    @else
                                        <span class="inline-flex items-center px-1.5 py-0.5 rounded text-[10px] font-bold bg-slate-100 text-slate-600">
                                            Admin
                                        </span>
                                    @endif
                                </div>
                            </td>

                            {{-- Columna 5: Estado & Moderación --}}
                            <td class="px-5 py-4">
                                @if ($d)
                                    <form action="{{ route('inmueble.estado', $item->id) }}" method="POST" class="inline-block">
                                        @csrf
                                        @method('PATCH')
                                        <select name="estado_publicacion"
                                                onchange="this.form.submit()"
                                                title="Cambiar estado de publicación"
                                                class="text-xs font-bold rounded-xl px-2.5 py-1.5 border cursor-pointer focus:outline-none transition {{ $badge($estado) }}">
                                            @foreach (['disponible', 'pendiente', 'arrendado', 'vendido', 'reservado', 'inactivo'] as $est)
                                                <option value="{{ $est }}" {{ $estado === $est ? 'selected' : '' }} class="bg-white text-slate-800">
                                                    {{ ucfirst($est) }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </form>

                                    {{-- Botones de moderación rápida si está pendiente --}}
                                    @if ($estado === 'pendiente')
                                        <div class="flex items-center gap-1.5 mt-2">
                                            <form action="{{ route('inmueble.estado', $item->id) }}" method="POST" class="inline">
                                                @csrf
                                                @method('PATCH')
                                                <input type="hidden" name="estado_publicacion" value="disponible">
                                                <button type="submit"
                                                        title="Aprobar y publicar en el portal público"
                                                        class="px-2.5 py-1 text-[11px] font-black rounded-lg bg-emerald-600 hover:bg-emerald-700 text-white shadow-sm transition inline-flex items-center gap-1 cursor-pointer">
                                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>
                                                    <span>Aprobar</span>
                                                </button>
                                            </form>
                                            <form action="{{ route('inmueble.estado', $item->id) }}" method="POST" class="inline"
                                                  onsubmit="return confirm('¿Rechazar este inmueble? Se marcará como inactivo.')">
                                                @csrf
                                                @method('PATCH')
                                                <input type="hidden" name="estado_publicacion" value="inactivo">
                                                <button type="submit"
                                                        title="Rechazar inmueble"
                                                        class="px-2 py-1 text-[11px] font-bold rounded-lg bg-rose-100 hover:bg-rose-200 text-rose-700 border border-rose-300 transition inline-flex items-center gap-0.5 cursor-pointer">
                                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12"/></svg>
                                                    <span>Rechazar</span>
                                                </button>
                                            </form>
                                        </div>
                                    @endif
                                @else
                                    <span class="text-xs text-slate-400">Sin detalle</span>
                                @endif
                            </td>

                            {{-- Columna 6: Acciones --}}
                            <td class="px-5 py-4 text-right">
                                <div class="inline-flex items-center gap-1">
                                    {{-- Desplegar Ficha --}}
                                    <button type="button"
                                            data-id="{{ $item->id }}"
                                            title="Ver detalles completos"
                                            class="p-2 rounded-xl text-slate-500 hover:text-blue-600 hover:bg-blue-50 border border-slate-200/80 transition cursor-pointer">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                                    </button>

                                    {{-- Ver en Web --}}
                                    <a href="{{ route('propiedad.show', $item->id) }}"
                                       class="p-2 rounded-xl text-slate-500 hover:text-emerald-600 hover:bg-emerald-50 border border-slate-200/80 transition cursor-pointer"
                                       title="Ver ficha pública en portal">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                                    </a>

                                    {{-- Editar --}}
                                    <a href="{{ route('inmueble.edit', $item->id) }}"
                                       class="p-2 rounded-xl text-slate-500 hover:text-amber-600 hover:bg-amber-50 border border-slate-200/80 transition"
                                       title="Editar inmueble">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                                    </a>

                                    {{-- Eliminar --}}
                                    <form action="{{ route('inmueble.destroy', $item->id) }}" method="POST"
                                          onsubmit="return confirm('¿Seguro que deseas eliminar este inmueble permanentemente?')"
                                          class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                                class="p-2 rounded-xl text-slate-500 hover:text-rose-600 hover:bg-rose-50 border border-slate-200/80 transition cursor-pointer"
                                                title="Eliminar inmueble">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6M9.5 4h5a1 1 0 011 1v2h-7V5a1 1 0 011-1z"/></svg>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>

                        {{-- Fila de detalles extendidos (oculta por defecto) --}}
                        <tr id="detalle-{{ $item->id }}" style="display: none;" class="bg-slate-50/70 border-b border-slate-200">
                            <td colspan="6" class="p-6">
                                <div class="bg-white rounded-2xl border border-slate-200 p-5 shadow-xs">
                                    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3 mb-4 pb-3 border-b border-slate-100">
                                        <div>
                                            <h4 class="font-bold text-slate-900 text-sm">Ficha Técnica &bull; {{ $item->nombre }}</h4>
                                            <p class="text-xs text-slate-400">{{ $d?->direccion ?? 'Sin dirección' }}</p>
                                        </div>
                                        <span class="text-xs text-slate-500">Publicado el {{ $d?->fecha_publicacion ?? 'N/A' }}</span>
                                    </div>

                                    {{-- Grilla de características --}}
                                    <div class="grid grid-cols-2 sm:grid-cols-4 md:grid-cols-6 gap-3 mb-4">
                                        <div class="bg-slate-50 p-3 rounded-xl border border-slate-200/80">
                                            <p class="text-[10px] uppercase font-bold text-slate-400">Precio</p>
                                            <p class="font-black text-slate-800 text-sm mt-0.5">${{ number_format($d?->precio ?? 0, 0, ',', '.') }}</p>
                                        </div>
                                        <div class="bg-slate-50 p-3 rounded-xl border border-slate-200/80">
                                            <p class="text-[10px] uppercase font-bold text-slate-400">Administración</p>
                                            <p class="font-black text-slate-800 text-sm mt-0.5">${{ number_format($d?->precio_administrador ?? 0, 0, ',', '.') }}</p>
                                        </div>
                                        <div class="bg-slate-50 p-3 rounded-xl border border-slate-200/80">
                                            <p class="text-[10px] uppercase font-bold text-slate-400">Área</p>
                                            <p class="font-black text-slate-800 text-sm mt-0.5">{{ $d?->area ?? 0 }} m²</p>
                                        </div>
                                        <div class="bg-slate-50 p-3 rounded-xl border border-slate-200/80">
                                            <p class="text-[10px] uppercase font-bold text-slate-400">Estrato</p>
                                            <p class="font-bold text-slate-800 text-sm mt-0.5">{{ $d?->estrato ? 'Estrato ' . $d->estrato : 'N/A' }}</p>
                                        </div>
                                        <div class="bg-slate-50 p-3 rounded-xl border border-slate-200/80">
                                            <p class="text-[10px] uppercase font-bold text-slate-400">Habitaciones</p>
                                            <p class="font-bold text-slate-800 text-sm mt-0.5">{{ $d?->numero_habitacion ?? '-' }}</p>
                                        </div>
                                        <div class="bg-slate-50 p-3 rounded-xl border border-slate-200/80">
                                            <p class="text-[10px] uppercase font-bold text-slate-400">Baños</p>
                                            <p class="font-bold text-slate-800 text-sm mt-0.5">{{ $d?->numero_bano ?? '-' }}</p>
                                        </div>
                                    </div>

                                    @if ($d?->descripcion)
                                        <p class="text-xs text-slate-600 bg-slate-50 p-3.5 rounded-xl border border-slate-200/80 italic mb-4">
                                            "{{ $d->descripcion }}"
                                        </p>
                                    @endif

                                    {{-- Galería de Fotos --}}
                                    @if ($item->imagenes->isNotEmpty())
                                        <div>
                                            <p class="text-xs font-bold text-slate-700 mb-2">Galería de fotos ({{ $item->imagenes->count() }}):</p>
                                            <div class="flex flex-wrap gap-2.5">
                                                @foreach ($item->imagenes as $img)
                                                    <a href="{{ asset('storage/' . ($img->url_imagen ?? $img->ruta_imagen)) }}" target="_blank" class="block w-24 h-20 rounded-xl overflow-hidden border border-slate-200 hover:opacity-90 shadow-2xs">
                                                        <img src="{{ asset('storage/' . ($img->url_imagen ?? $img->ruta_imagen)) }}" class="w-full h-full object-cover">
                                                    </a>
                                                @endforeach
                                            </div>
                                        </div>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-5 py-12 text-center text-slate-400">
                                <div class="w-12 h-12 rounded-2xl bg-slate-100 flex items-center justify-center mx-auto mb-2 text-slate-300">
                                    🏡
                                </div>
                                <p class="font-bold text-slate-700">No hay inmuebles registrados aún.</p>
                                <p class="text-xs text-slate-400 mt-1">Comienza publicando el primero con el botón "+ Publicar Inmueble".</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

</div>

<script>
    document.querySelectorAll('button[data-id]').forEach(boton => {
        boton.addEventListener('click', () => {
            const fila = document.getElementById('detalle-' + boton.dataset.id);
            const oculto = fila.style.display === 'none';
            fila.style.display = oculto ? 'table-row' : 'none';
            boton.classList.toggle('bg-blue-50', oculto);
            boton.classList.toggle('text-blue-600', oculto);
        });
    });
</script>

@endsection
