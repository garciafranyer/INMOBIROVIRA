@props(['inmueble'])

@php
    $d = $inmueble->detalle_inmueble;
    $foto = $inmueble->imagenes->first();
    $totalFotos = $inmueble->imagenes->count();
    $esArriendo = strtolower($d->tipo_oferta ?? '') === 'arriendo';
@endphp

<article class="group bg-neutral-900 rounded-2xl border border-neutral-800 hover:border-neutral-700 shadow-xl hover:shadow-2xl hover:shadow-blue-950/20 hover:-translate-y-1.5 transition-all duration-300 flex flex-col overflow-hidden">
    {{-- Contenedor de Imagen y Badges Flotantes --}}
    <div class="relative w-full h-52 bg-neutral-950 overflow-hidden">
        <a href="{{ route('propiedad.show', $inmueble->id) }}" class="block w-full h-full">
            @if ($foto)
                <img src="{{ asset('storage/' . $foto->url_imagen) }}"
                     alt="{{ $inmueble->nombre }}"
                     loading="lazy"
                     class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500 ease-out">
            @else
                <div class="w-full h-full flex flex-col items-center justify-center text-neutral-600 bg-neutral-950 gap-1">
                    <svg class="w-8 h-8 opacity-40" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                    </svg>
                    <span class="text-xs">Sin imagen</span>
                </div>
            @endif
        </a>

        {{-- Badge Flotante Superior Izquierdo: Tipo Oferta y Tipo Inmueble --}}
        <div class="absolute top-3 left-3 flex items-center gap-1.5">
            <span class="px-3 py-1 rounded-full text-xs font-bold uppercase tracking-wider shadow-md backdrop-blur-md {{ $esArriendo ? 'bg-emerald-600/90 text-white' : 'bg-blue-600/90 text-white' }}">
                {{ ucfirst($d->tipo_oferta ?? 'Oferta') }}
            </span>
            @if ($inmueble->tipo_inmueble)
                <span class="px-2.5 py-1 rounded-full text-xs font-medium bg-black/70 text-neutral-200 border border-white/10 backdrop-blur-md shadow-sm">
                    {{ $inmueble->tipo_inmueble->nombre }}
                </span>
            @endif
        </div>

        {{-- Badge Flotante Superior Derecho: Contador de Fotos --}}
        @if ($totalFotos > 0)
            <div class="absolute top-3 right-3 px-2.5 py-1 rounded-full text-xs font-medium bg-black/70 text-neutral-200 border border-white/10 backdrop-blur-md flex items-center gap-1 shadow-sm">
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z" />
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z" />
                </svg>
                <span>{{ $totalFotos }}</span>
            </div>
        @endif
    </div>

    {{-- Contenido de la Tarjeta --}}
    <div class="p-5 flex-1 flex flex-col justify-between">
        <div>
            {{-- Ubicación --}}
            <div class="flex items-center gap-1.5 text-xs text-neutral-400 font-medium mb-1.5">
                <svg class="w-3.5 h-3.5 text-blue-400 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                </svg>
                <span class="truncate">{{ $inmueble->municipio?->nombre }} @if($d?->direccion) · {{ $d->direccion }} @endif</span>
            </div>

            {{-- Nombre del Inmueble --}}
            <h3 class="font-bold text-base sm:text-lg text-white group-hover:text-blue-400 transition-colors line-clamp-1">
                <a href="{{ route('propiedad.show', $inmueble->id) }}">
                    {{ $inmueble->nombre }}
                </a>
            </h3>

            {{-- Precio --}}
            <div class="mt-2.5 flex items-baseline gap-1">
                <span class="text-2xl font-black text-white tracking-tight">
                    ${{ number_format($d->precio ?? 0, 0, ',', '.') }}
                </span>
                @if ($esArriendo)
                    <span class="text-xs font-semibold text-neutral-400">/ mes</span>
                @endif
            </div>
        </div>

        {{-- Características con iconos SVG --}}
        <div class="mt-4 pt-3.5 border-t border-neutral-800">
            <div class="grid grid-cols-3 gap-2 text-xs text-neutral-300">
                {{-- Habitaciones --}}
                <div class="flex items-center gap-1.5" title="Habitaciones">
                    <svg class="w-4 h-4 text-neutral-500 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                    </svg>
                    <span class="font-medium truncate">{{ $d->numero_habitacion ?? '-' }} hab.</span>
                </div>

                {{-- Baños --}}
                <div class="flex items-center gap-1.5" title="Baños">
                    <svg class="w-4 h-4 text-neutral-500 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 14v5m4-5v5m4-5v5M4 11h16a1 1 0 011 1v3a4 4 0 01-4 4H7a4 4 0 01-4-4v-3a1 1 0 011-1zm0 0V7a3 3 0 013-3h2" />
                    </svg>
                    <span class="font-medium truncate">{{ $d->numero_bano ?? '-' }} baños</span>
                </div>

                {{-- Área --}}
                <div class="flex items-center gap-1.5" title="Área total">
                    <svg class="w-4 h-4 text-neutral-500 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 8V4m0 0h4M4 4l5 5m11-1V4m0 0h-4m4 0l-5 5M4 16v4m0 0h4m-4 0l5-5m11 5l-5-5m5 5v-4m0 4h-4" />
                    </svg>
                    <span class="font-medium truncate">{{ $d->area ?? '-' }} m²</span>
                </div>
            </div>

            {{-- Fila inferior: Ver detalle con micro-interacción --}}
            <div class="mt-3.5 pt-2.5 border-t border-dashed border-neutral-800 flex items-center justify-between">
                <span class="text-xs text-neutral-400">
                    @if ($d?->numero_parqueadero)
                        🚗 {{ $d->numero_parqueadero }} parq.
                    @else
                        Zona {{ ucfirst($inmueble->zona ?? 'urbana') }}
                    @endif
                </span>
                <a href="{{ route('propiedad.show', $inmueble->id) }}"
                   class="inline-flex items-center gap-1 text-xs font-semibold text-blue-400 hover:text-blue-300 transition">
                    <span>Ver detalles</span>
                    <svg class="w-3.5 h-3.5 transition-transform duration-200 group-hover:translate-x-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                    </svg>
                </a>
            </div>
        </div>
    </div>
</article>
