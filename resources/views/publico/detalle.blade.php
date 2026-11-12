@extends('layouts.publico')

@section('title', $inmueble->nombre)

@push('styles')
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" crossorigin=""/>
<style>
    .leaflet-container { font-family: inherit; }
    .custom-pin-marcador { pointer-events: auto; }
</style>
@endpush

@section('content')

@php
    $d = $inmueble->detalle_inmueble;
    $telefono = preg_replace('/\D/', '', $inmueble->usuario?->telefono ?? '');
    $listaImagenes = $inmueble->imagenes->map(fn($img) => asset('storage/' . $img->url_imagen))->values();
@endphp

<a href="{{ route('inicio') }}" class="text-sm text-blue-400 hover:text-blue-300 inline-flex items-center gap-1.5 font-medium transition mb-2">
    &larr; Volver al listado
</a>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-8 mt-2">

    {{-- Galería --}}
    <div class="lg:col-span-2">
        @if ($inmueble->imagenes->isNotEmpty())
            <div class="grid grid-cols-2 sm:grid-cols-3 gap-3">
                @foreach ($inmueble->imagenes as $img)
                    <button type="button"
                            onclick="abrirVisor({{ $loop->index }})"
                            class="group relative overflow-hidden rounded-2xl border border-neutral-800 focus:outline-hidden text-left cursor-pointer {{ $loop->first ? 'col-span-2 sm:col-span-3' : '' }}">
                        <img src="{{ asset('storage/' . $img->url_imagen) }}"
                            alt="{{ $inmueble->nombre }}"
                            class="w-full {{ $loop->first ? 'h-96' : 'h-40' }} object-cover group-hover:scale-102 group-hover:brightness-95 transition-all duration-300">

                        {{-- Indicador flotante al pasar el mouse --}}
                        <div class="absolute inset-0 bg-black/0 group-hover:bg-black/30 transition flex items-center justify-center opacity-0 group-hover:opacity-100">
                            <span class="p-2.5 bg-black/80 text-white rounded-full shadow-lg backdrop-blur-md flex items-center gap-1.5 text-xs font-medium border border-white/10">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0zM10 7v6m3-3H7" />
                                </svg>
                                <span>Ver en carrusel</span>
                            </span>
                        </div>
                    </button>
                @endforeach
            </div>
        @else
            <div class="w-full h-96 bg-neutral-900 border border-neutral-800 rounded-2xl flex items-center justify-center text-neutral-500">Sin fotos</div>
        @endif

        <div class="mt-8 bg-neutral-900 border border-neutral-800 rounded-2xl p-6 shadow-xl">
            <h2 class="text-lg font-bold mb-2 text-white">Descripción</h2>
            <p class="text-neutral-300 leading-relaxed">{{ $d->descripcion }}</p>
        </div>
    </div>

    {{-- Información Lateral --}}
    <div class="space-y-6">
        <div class="bg-neutral-900 border border-neutral-800 rounded-2xl p-6 shadow-xl">
            <div class="flex items-center gap-2 text-xs mb-2">
                <span class="px-2.5 py-1 rounded-full bg-blue-900/60 text-blue-300 border border-blue-700/50 font-semibold">{{ ucfirst($d->tipo_oferta) }}</span>
                <span class="text-neutral-400">{{ $inmueble->tipo_inmueble?->nombre }}</span>
            </div>

            @php
                $esVda = $inmueble->barrio && (str_contains(strtolower($inmueble->barrio->nombre), 'vda') || str_contains(strtolower($inmueble->barrio->nombre), 'vereda') || strtolower($inmueble->zona) === 'rural');
                $etiquetaSubdiv = $esVda ? 'Vereda ' : 'Barrio ';
            @endphp

            <h1 class="text-2xl font-bold text-white">{{ $inmueble->nombre }}</h1>
            <p class="text-neutral-400 mt-1">
                {{ $inmueble->municipio?->nombre }}@if($inmueble->barrio) · {{ $etiquetaSubdiv }}{{ str_ireplace('vda. ', '', $inmueble->barrio->nombre) }}@endif · {{ $d->direccion }}
            </p>

            <p class="text-3xl font-black text-white mt-4">${{ number_format($d->precio, 0, ',', '.') }}</p>
            <p class="text-sm text-neutral-400 mt-0.5">Administración: ${{ number_format($d->precio_administrador, 0, ',', '.') }}</p>

            @php
                $rawTel = preg_replace('/\D/', '', $inmueble->usuario?->telefono ?? '');
                $telWa = (!empty($rawTel) && strlen($rawTel) >= 10)
                    ? (str_starts_with($rawTel, '57') ? $rawTel : '57' . $rawTel)
                    : config('services.whatsapp.numero', '573103451093');

                $subdivTexto = $inmueble->barrio ? ' (' . $etiquetaSubdiv . str_ireplace('vda. ', '', $inmueble->barrio->nombre) . ')' : '';
                $municipio = ($inmueble->municipio?->nombre ?? 'García Rovira') . $subdivTexto;
                $precio    = number_format($d->precio ?? 0, 0, ',', '.');
                $oferta    = ucfirst($d->tipo_oferta ?? 'Oferta');
                $url       = url()->current();

                $mensajeDetalle = "👋 *¡Hola Inmobirovira!*\n\n"
                    . "Me interesa este inmueble que vi en su página web:\n"
                    . "🏡 *Propiedad:* {$inmueble->nombre}\n"
                    . "📍 *Ubicación:* {$municipio}\n"
                    . "🏷️ *Tipo:* {$oferta}\n"
                    . "💰 *Precio:* \${$precio}\n"
                    . "🆔 *Código:* #{$inmueble->id}\n\n"
                    . "🔗 *Enlace:* {$url}";
            @endphp

            <a href="https://api.whatsapp.com/send?phone={{ $telWa }}&text={{ rawurlencode($mensajeDetalle) }}"
                target="_blank"
                rel="noopener noreferrer"
                class="mt-6 flex items-center justify-center gap-2 bg-[#25D366] hover:bg-[#20bd5a] text-white font-bold px-5 py-3.5 rounded-xl shadow-lg shadow-emerald-950 transition transform hover:scale-102 cursor-pointer">
                <svg class="w-5 h-5 shrink-0" fill="currentColor" viewBox="0 0 24 24">
                    <path d="M.057 24l1.687-6.163c-1.041-1.804-1.588-3.849-1.587-5.946.003-6.556 5.338-11.891 11.893-11.891 3.181.001 6.167 1.24 8.413 3.488 2.245 2.248 3.481 5.236 3.48 8.414-.003 6.557-5.338 11.892-11.893 11.892-1.99-.001-3.951-.5-5.688-1.448l-6.305 1.654zm6.597-3.807c1.676.995 3.276 1.591 5.392 1.592 5.448 0 9.886-4.434 9.889-9.885.002-5.462-4.415-9.89-9.881-9.892-5.452 0-9.887 4.434-9.889 9.884-.001 2.225.651 3.891 1.746 5.634l-.999 3.648 3.742-.981zm11.387-5.464c-.074-.124-.272-.198-.57-.347-.297-.149-1.758-.868-2.031-.967-.272-.099-.47-.149-.669.149-.198.297-.768.967-.941 1.165-.173.198-.347.223-.644.074-.297-.149-1.255-.462-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.297-.347.446-.521.151-.172.2-.296.3-.495.099-.198.05-.372-.025-.521-.075-.148-.669-1.611-.916-2.206-.242-.579-.487-.501-.669-.51l-.57-.01c-.198 0-.52.074-.792.372s-1.04 1.016-1.04 2.479 1.065 2.876 1.213 3.074c.149.198 2.095 3.2 5.076 4.487.709.306 1.263.489 1.694.626.712.226 1.36.194 1.872.118.571-.085 1.758-.719 2.006-1.413.248-.695.248-1.29.173-1.414z"/>
                </svg>
                <span>Contactar por WhatsApp</span>
            </a>

            {{-- Botón para compartir por WhatsApp (100% enlace HTML puro, sin JavaScript, sin Facebook) --}}
            <a href="https://api.whatsapp.com/send?text={{ urlencode('Te comparto esta propiedad en Inmobirovira: ' . $inmueble->nombre . ' - ' . url()->current()) }}"
                target="_blank"
                rel="noopener noreferrer"
                class="mt-2.5 flex items-center justify-center gap-2 bg-neutral-800 hover:bg-neutral-700 text-neutral-200 hover:text-white font-semibold text-xs sm:text-sm px-4 py-2.5 rounded-xl border border-neutral-700/80 transition cursor-pointer">
                <svg class="w-4 h-4 text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.684 13.342C8.886 12.938 9 12.482 9 12c0-.482-.114-.938-.316-1.342m0 2.684a3 3 0 110-2.684m0 2.684l6.632 3.316m-6.632-6l6.632-3.316m0 0a3 3 0 105.367-2.684 3 3 0 00-5.367 2.684zm0 9.316a3 3 0 105.368 2.684 3 3 0 00-5.368-2.684z" />
                </svg>
                <span>Compartir por WhatsApp</span>
            </a>
        </div>

        <div class="bg-neutral-900 border border-neutral-800 rounded-2xl p-6 shadow-xl">
            <h2 class="text-lg font-bold mb-3 text-white">Características</h2>
            @php
                $tipoNombre = strtolower($inmueble->tipo_inmueble?->nombre ?? '');
                $esLote = str_contains($tipoNombre, 'lote') || (str_contains($tipoNombre, 'terreno') && !str_contains($tipoNombre, 'campestre'));
                $esLocal = str_contains($tipoNombre, 'local') || str_contains($tipoNombre, 'comercial');
                $esFinca = str_contains($tipoNombre, 'finca') || str_contains($tipoNombre, 'campestre');
                $esCasa = str_contains($tipoNombre, 'casa');
            @endphp
            <dl class="grid grid-cols-2 gap-3 text-sm">
                @if(!empty($d->area))
                    <div><dt class="text-neutral-400">Área</dt><dd class="font-semibold text-white">{{ $d->area }} m²</dd></div>
                @endif

                @if($inmueble->barrio)
                    <div><dt class="text-neutral-400">{{ $esVda ? 'Vereda' : 'Barrio' }}</dt><dd class="font-semibold text-white">{{ $inmueble->barrio->nombre }}</dd></div>
                @endif

                @if(!empty($d->estrato))
                    <div><dt class="text-neutral-400">Estrato</dt><dd class="font-semibold text-white">Estrato {{ $d->estrato }}</dd></div>
                @endif

                {{-- Habitaciones: NO en Lote, NO en Local --}}
                @if(!$esLote && !$esLocal && !is_null($d->numero_habitacion) && (int)$d->numero_habitacion > 0)
                    <div><dt class="text-neutral-400">Habitaciones</dt><dd class="font-semibold text-white">{{ $d->numero_habitacion }}</dd></div>
                @endif

                {{-- Baños: NO en Lote --}}
                @if(!$esLote && !is_null($d->numero_bano) && (int)$d->numero_bano > 0)
                    <div><dt class="text-neutral-400">Baños</dt><dd class="font-semibold text-white">{{ $d->numero_bano }}</dd></div>
                @endif

                {{-- Parqueaderos: NO en Lote --}}
                @if(!$esLote && !is_null($d->numero_parqueadero) && (int)$d->numero_parqueadero > 0)
                    <div><dt class="text-neutral-400">Parqueaderos</dt><dd class="font-semibold text-white">{{ $d->numero_parqueadero }}</dd></div>
                @endif

                {{-- Antigüedad: NO en Lote --}}
                @if(!$esLote && !empty($d->antiguedad))
                    <div><dt class="text-neutral-400">Antigüedad</dt><dd class="font-semibold text-white">{{ $d->antiguedad }}</dd></div>
                @endif

                {{-- Mascotas: NO en Lote, NO en Local --}}
                @if(!$esLote && !$esLocal && isset($d->mascotas_permitidas))
                    <div><dt class="text-neutral-400">Mascotas 🐾</dt><dd class="font-semibold text-white">{{ $d->mascotas_permitidas ? 'Sí permitidas' : 'No permitidas' }}</dd></div>
                @endif

                {{-- Piso: NO en Lote, NO en Finca --}}
                @if(!$esLote && !$esFinca && !empty($d->numero_piso))
                    <div><dt class="text-neutral-400">Piso</dt><dd class="font-semibold text-white">{{ $d->numero_piso }}</dd></div>
                @endif

                {{-- Apartamento: SOLO en Apartamento --}}
                @if(!$esLote && !$esLocal && !$esFinca && !$esCasa && !empty($d->numero_apartamento))
                    <div><dt class="text-neutral-400">Apartamento</dt><dd class="font-semibold text-white">{{ $d->numero_apartamento }}</dd></div>
                @endif

                <div><dt class="text-neutral-400">Zona</dt><dd class="font-semibold text-white">{{ ucfirst($inmueble->zona) }}</dd></div>
                @if(!empty($d->fecha_publicacion))
                    <div><dt class="text-neutral-400">Publicado</dt><dd class="font-semibold text-white">{{ $d->fecha_publicacion }}</dd></div>
                @endif
            </dl>
        </div>
    </div>

</div>
{{-- UBICACIÓN EN GOOGLE MAPS Y VISTA 360° STREET VIEW --}}
@php
    $tieneCoords = !empty($d->latitud) && !empty($d->longitud);
    $lat = $tieneCoords ? (float)$d->latitud : null;
    $lng = $tieneCoords ? (float)$d->longitud : null;

    $urlGoogleMapsExacto = $tieneCoords
        ? ('https://www.google.com/maps/search/?api=1&query=' . $lat . ',' . $lng)
        : ('https://www.google.com/maps/search/?api=1&query=' . urlencode($d->direccion . ', ' . ($inmueble->barrio?->nombre ? $inmueble->barrio->nombre . ', ' : '') . ($inmueble->municipio?->nombre ?? 'Santander') . ', Colombia'));

    $urlComoLlegar = $tieneCoords
        ? ('https://www.google.com/maps/dir/?api=1&destination=' . $lat . ',' . $lng)
        : ('https://www.google.com/maps/search/?api=1&query=' . urlencode($d->direccion . ', ' . ($inmueble->barrio?->nombre ? $inmueble->barrio->nombre . ', ' : '') . ($inmueble->municipio?->nombre ?? 'Santander') . ', Colombia'));

    $urlStreetViewDirecto = $tieneCoords
        ? ('https://www.google.com/maps/@?api=1&map_action=pano&viewpoint=' . $lat . ',' . $lng)
        : ('https://www.google.com/maps/search/?api=1&query=' . urlencode($d->direccion . ', ' . ($inmueble->municipio?->nombre ?? 'Santander') . ', Colombia'));

    $urlStreetViewEmbed = $tieneCoords
        ? ('https://maps.google.com/maps?layer=c&cbll=' . $lat . ',' . $lng . '&cbp=11,0,0,0,0&output=svembed')
        : null;
@endphp
<div x-data="{ activeMapTab: 'satelite' }" class="mt-8 bg-neutral-900 border border-neutral-800 rounded-2xl p-6 shadow-xl">
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-5">
        <div>
            <h2 class="text-lg font-bold text-white flex items-center gap-2">
                <svg class="w-5 h-5 text-red-500" fill="currentColor" viewBox="0 0 24 24">
                    <path d="M12 2C8.13 2 5 5.13 5 9c0 5.25 7 13 7 13s7-7.75 7-13c0-3.87-3.13-7-7-7zm0 9.5c-1.38 0-2.5-1.12-2.5-2.5s1.12-2.5 2.5-2.5 2.5 1.12 2.5 2.5-1.12 2.5-2.5 2.5z"/>
                </svg>
                <span>Ubicación del inmueble</span>
                @if($tieneCoords)
                    <span class="inline-flex items-center gap-1 text-[10px] font-bold uppercase tracking-wider text-emerald-400 bg-emerald-950/80 border border-emerald-800/80 px-2 py-0.5 rounded-full">
                        <span class="w-1.5 h-1.5 rounded-full bg-emerald-400 animate-pulse"></span>
                        GPS Exacto
                    </span>
                @endif
            </h2>
            <p class="text-xs text-neutral-400 mt-0.5">
                {{ $d->direccion }}@if($inmueble->barrio), {{ $etiquetaSubdiv }}{{ str_ireplace('vda. ', '', $inmueble->barrio->nombre) }}@endif, {{ $inmueble->municipio?->nombre ?? 'Santander' }}
            </p>
        </div>

        <div class="flex items-center gap-2 flex-wrap">
            <a href="{{ $urlGoogleMapsExacto }}"
                target="_blank" 
                rel="noopener noreferrer"
                class="inline-flex items-center gap-1.5 px-3.5 py-1.5 rounded-xl text-xs font-semibold bg-neutral-800 hover:bg-neutral-700 text-neutral-200 hover:text-white border border-neutral-700 transition shadow-sm">
                <svg class="w-4 h-4 text-red-500" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2C8.13 2 5 5.13 5 9c0 5.25 7 13 7 13s7-7.75 7-13c0-3.87-3.13-7-7-7zm0 9.5c-1.38 0-2.5-1.12-2.5-2.5s1.12-2.5 2.5-2.5 2.5 1.12 2.5 2.5-1.12 2.5-2.5 2.5z"/></svg>
                <span>Abrir en Google Maps</span>
            </a>

            <a href="{{ $urlComoLlegar }}" 
                target="_blank" 
                rel="noopener noreferrer"
                class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-xl text-xs font-semibold bg-blue-600 hover:bg-blue-500 text-white shadow-md shadow-blue-600/30 transition">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/></svg>
                <span>Cómo llegar</span>
            </a>
        </div>
    </div>

    {{-- Selector de Pestañas: Satélite / Vista 360° --}}
    <div class="flex items-center gap-2 mb-4">
        <button type="button"
                @click="activeMapTab = 'satelite'; $nextTick(() => { if (window.mapPublico) window.mapPublico.invalidateSize(); })"
                :class="activeMapTab === 'satelite' ? 'bg-blue-600 text-white shadow-md shadow-blue-600/30' : 'bg-neutral-800 text-neutral-400 hover:text-white'"
                class="inline-flex items-center gap-1.5 px-4 py-2 rounded-xl text-xs font-bold transition cursor-pointer">
            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064"/></svg>
            <span>🛰️ Vista Satélite</span>
        </button>
    </div>

    {{-- 1. Mapa Satélite con Marcador Físico Exacto --}}
    <div x-show="activeMapTab === 'satelite'" class="w-full h-125 rounded-xl overflow-hidden border border-neutral-800 relative z-0">
        @if($tieneCoords)
            <div id="mapa-publico" class="w-full h-full"></div>
        @else
            <iframe 
                width="100%" 
                height="100%" 
                style="border:0;" 
                loading="lazy" 
                allowfullscreen 
                referrerpolicy="no-referrer-when-downgrade"
                src="https://maps.google.com/maps?q={{ urlencode($d->direccion . ', ' . ($inmueble->barrio?->nombre ? $inmueble->barrio->nombre . ', ' : '') . ($inmueble->municipio?->nombre ?? '') . ', Santander, Colombia') }}&t=k&z=16&ie=UTF8&iwloc=&output=embed">
            </iframe>
        @endif
    </div>
</div>

{{-- SECCIÓN DE INMUEBLES SIMILARES --}}
@if(isset($similares) && $similares->isNotEmpty())
    <section class="mt-16 pt-10 border-t border-neutral-800">
        <div class="flex flex-col sm:flex-row sm:items-end justify-between gap-3 mb-8">
            <div>
                <span class="text-xs font-bold uppercase tracking-widest text-neutral-500 block mb-1">Recomendaciones</span>
                <h2 class="text-2xl sm:text-3xl font-black text-white tracking-tight">Otras propiedades que te podrían interesar</h2>
                <p class="text-sm text-neutral-400 mt-1">
                    Inmuebles similares en {{ $inmueble->municipio?->nombre ?? 'la provincia' }} o de tipo {{ strtolower($inmueble->tipo_inmueble?->nombre ?? 'inmueble') }}.
                </p>
            </div>
            <a href="{{ route('inicio') }}#inmuebles" class="inline-flex items-center gap-1.5 text-xs font-semibold text-blue-400 hover:text-blue-300 transition shrink-0">
                <span>Ver todo el catálogo</span>
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3" />
                </svg>
            </a>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach ($similares as $similar)
                <x-publico.tarjeta-inmueble :inmueble="$similar" />
            @endforeach
        </div>
    </section>
@endif

{{-- MODAL LIGHTBOX / CARRUSEL INTERACTIVO --}}
<div id="visor-carrusel" class="fixed inset-0 z-50 hidden bg-black/95 backdrop-blur-md flex-col justify-between p-4 sm:p-6 select-none">
    {{-- Barra superior --}}
    <div class="flex items-center justify-between text-white max-w-7xl mx-auto w-full pt-2 px-2">
        <div class="text-xs sm:text-sm font-semibold tracking-wide bg-neutral-900 px-3.5 py-1.5 rounded-full border border-neutral-800 text-neutral-300">
            <span id="visor-contador">1 de 1</span>
        </div>
        <button type="button"
                onclick="cerrarVisor()"
                class="p-2 rounded-full bg-neutral-900 hover:bg-neutral-800 text-neutral-400 hover:text-white transition cursor-pointer border border-neutral-800"
                title="Cerrar (Esc)">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
            </svg>
        </button>
    </div>

    {{-- Área central de la foto con flechas --}}
    <div id="visor-contenedor-central" class="relative flex-1 flex items-center justify-center max-w-7xl mx-auto w-full my-2">
        {{-- Flecha anterior --}}
        <button type="button"
                onclick="moverFoto(-1)"
                class="absolute left-2 sm:left-6 z-20 p-3 sm:p-4 rounded-full bg-black/70 hover:bg-black text-white transition backdrop-blur-md border border-neutral-800 shadow-2xl cursor-pointer"
                title="Foto anterior (←)">
            <svg class="w-6 h-6 sm:w-8 sm:h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15 19l-7-7 7-7" />
            </svg>
        </button>

        {{-- Imagen activa --}}
        <div class="max-h-[75vh] max-w-full flex items-center justify-center p-2">
            <img id="visor-imagen"
                src=""
                alt="Vista previa del inmueble"
                class="max-h-[72vh] max-w-full object-contain rounded-xl shadow-2xl transition-opacity duration-200">
        </div>

        {{-- Flecha siguiente --}}
        <button type="button"
                onclick="moverFoto(1)"
                class="absolute right-2 sm:right-6 z-20 p-3 sm:p-4 rounded-full bg-black/70 hover:bg-black text-white transition backdrop-blur-md border border-neutral-800 shadow-2xl cursor-pointer"
                title="Siguiente foto (→)">
            <svg class="w-6 h-6 sm:w-8 sm:h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7" />
            </svg>
        </button>
    </div>

    {{-- Barra inferior de miniaturas --}}
    <div class="max-w-4xl mx-auto w-full pb-2 overflow-x-auto">
        <div id="visor-miniaturas" class="flex items-center justify-center gap-2 px-2 py-1">
            @foreach ($inmueble->imagenes as $i => $img)
                <button type="button"
                        onclick="irAFoto({{ $i }})"
                        data-indice="{{ $i }}"
                        class="visor-thumb w-14 h-14 sm:w-16 sm:h-16 rounded-xl overflow-hidden border-2 border-neutral-800 hover:border-blue-500 opacity-60 hover:opacity-100 transition shrink-0 cursor-pointer">
                    <img src="{{ asset('storage/' . $img->url_imagen) }}" class="w-full h-full object-cover">
                </button>
            @endforeach
        </div>
    </div>
</div>

<script>
    const fotos = @json($listaImagenes);
    let fotoActual = 0;
    const visor = document.getElementById('visor-carrusel');
    const visorImg = document.getElementById('visor-imagen');
    const visorContador = document.getElementById('visor-contador');
    const thumbs = document.querySelectorAll('.visor-thumb');

    function actualizarVisor() {
        if (!fotos.length) return;
        visorImg.style.opacity = '0.4';
        visorImg.src = fotos[fotoActual];
        setTimeout(() => {
            visorImg.style.opacity = '1';
        }, 80);

        visorContador.textContent = `${fotoActual + 1} de ${fotos.length}`;

        thumbs.forEach((th, idx) => {
            if (idx === fotoActual) {
                th.classList.add('border-blue-500', 'opacity-100', 'scale-105');
                th.classList.remove('border-neutral-800', 'opacity-60');
                th.scrollIntoView({ behavior: 'smooth', block: 'nearest', inline: 'center' });
            } else {
                th.classList.remove('border-blue-500', 'opacity-100', 'scale-105');
                th.classList.add('border-neutral-800', 'opacity-60');
            }
        });
    }

    function abrirVisor(indice) {
        fotoActual = indice;
        actualizarVisor();
        visor.classList.remove('hidden');
        document.body.style.overflow = 'hidden';
    }

    function cerrarVisor() {
        visor.classList.add('hidden');
        document.body.style.overflow = '';
    }

    function moverFoto(direccion) {
        if (!fotos.length) return;
        fotoActual = (fotoActual + direccion + fotos.length) % fotos.length;
        actualizarVisor();
    }

    function irAFoto(indice) {
        fotoActual = indice;
        actualizarVisor();
    }

    // Navegación con el teclado
    document.addEventListener('keydown', (e) => {
        if (visor.classList.contains('hidden')) return;
        if (e.key === 'Escape') cerrarVisor();
        if (e.key === 'ArrowRight') moverFoto(1);
        if (e.key === 'ArrowLeft') moverFoto(-1);
    });

    // Cerrar al hacer clic fuera de la foto en el fondo
    visor.addEventListener('click', (e) => {
        if (e.target.id === 'visor-contenedor-central' || e.target.id === 'visor-carrusel') {
            cerrarVisor();
        }
    });
</script>

@if($tieneCoords)
@push('scripts')
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" crossorigin=""></script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const lat = {{ $lat }};
        const lng = {{ $lng }};

        // Capa Satélite Google de alta resolución
        const satelite = L.tileLayer('https://mt1.google.com/vt/lyrs=y&x={x}&y={y}&z={z}', {
            maxZoom: 20,
            attribution: '&copy; Google Maps'
        });

        // Capa Calles
        const calles = L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            maxZoom: 19,
            attribution: '&copy; OpenStreetMap contributors'
        });

        const map = L.map('mapa-publico', {
            center: [lat, lng],
            zoom: 18,
            layers: [satelite]
        });

        window.mapPublico = map;

        // Selector de capas
        L.control.layers({
            "🛰️ Satélite (Casas)": satelite,
            "🗺️ Calles (Mapa)": calles
        }, null, { position: 'topright' }).addTo(map);

        // Marcador visual rojo físico de alta visibilidad
        const pinIcon = L.divIcon({
            className: 'custom-pin-marcador',
            html: `
                <div style="position: relative; width: 38px; height: 46px; filter: drop-shadow(0 4px 10px rgba(0,0,0,0.6));">
                    <svg viewBox="0 0 24 24" fill="none" style="width: 100%; height: 100%;">
                        <path d="M12 2C8.13 2 5 5.13 5 9c0 5.25 7 13 7 13s7-7.75 7-13c0-3.87-3.13-7-7-7z" fill="#EF4444" stroke="#FFFFFF" stroke-width="1.8"/>
                        <circle cx="12" cy="9" r="3.2" fill="#FFFFFF"/>
                    </svg>
                </div>
            `,
            iconSize: [38, 46],
            iconAnchor: [19, 46],
            popupAnchor: [0, -46]
        });

        const marker = L.marker([lat, lng], { icon: pinIcon }).addTo(map);

        marker.bindPopup(`
            <div style="font-family: inherit; min-width: 180px; padding: 4px;">
                <div style="font-weight: 700; font-size: 13px; color: #111827; margin-bottom: 2px;">{{ addslashes($inmueble->nombre) }}</div>
                <div style="font-size: 11px; color: #4B5563;">{{ addslashes($d->direccion) }}</div>
                <div style="margin-top: 6px; font-size: 11px; font-weight: 600; color: #2563EB;">📍 Ubicación fijada de la propiedad</div>
            </div>
        `).openPopup();
    });
</script>
@endpush
@endif

@endsection
