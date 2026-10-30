@extends('layouts.publico')

@section('title', 'Inicio - Encuentra tu próximo inmueble')
@section('header_transparent', 'true')

@section('hero')
{{-- PORTADA HERO COMPLETA DESDE EL BORDE SUPERIOR --}}
<section class="relative min-h-165 sm:min-h-185 flex items-center justify-center bg-cover bg-center text-white px-4 pt-36 sm:pt-44 pb-20"
         style="background-image: url('https://images.unsplash.com/photo-1600585154340-be6161a56a0c?auto=format&fit=crop&w=2000&q=80');">
    
    {{-- Capa degradada que se funde en el negro azabache (neutral-900) --}}
    <div class="absolute inset-0 bg-linear-to-b from-black/80 via-black/55 to-neutral-900"></div>

    <div class="relative z-10 max-w-5xl mx-auto w-full text-center flex flex-col items-center">
        
        {{-- Título Central --}}
        <h1 class="text-3xl sm:text-5xl lg:text-6xl font-black tracking-tight text-white drop-shadow-2xl max-w-4xl leading-tight">
            Lo mejor de buscar es encontrar
        </h1>
        <p class="mt-3 text-sm sm:text-base text-neutral-300 max-w-xl font-normal drop-shadow-md">
            Explora las mejores opciones de García Rovira en venta y arriendo
        </p>

        {{-- Cápsula Flotante de Búsqueda Estilo Dark Glass --}}
        <form method="GET" action="{{ route('inicio') }}#inmuebles"
              class="mt-8 sm:mt-10 w-full max-w-4xl bg-neutral-900/90 backdrop-blur-xl rounded-3xl md:rounded-full shadow-2xl p-2 sm:p-2.5 flex flex-col md:flex-row items-center border border-neutral-700/80 gap-2">
            
            {{-- Conservar tipo_oferta si viene de la barra superior --}}
            @if(!empty($filtros['tipo_oferta']))
                <input type="hidden" name="tipo_oferta" value="{{ $filtros['tipo_oferta'] }}">
            @endif

            {{-- Segmento 1: Tipo de inmueble --}}
            <div class="w-full md:w-1/3 px-4 py-1 text-left">
                <label for="id_tipo_inmueble" class="block text-[11px] font-bold uppercase tracking-wider text-neutral-400">
                    Tipo de inmueble
                </label>
                <select name="id_tipo_inmueble" id="id_tipo_inmueble"
                        class="w-full text-sm font-semibold text-white bg-transparent focus:outline-hidden cursor-pointer pt-0.5">
                    <option value="" class="bg-neutral-900 text-white">Todos los tipos</option>
                    @foreach($tipos_inmueble as $t)
                        <option value="{{ $t->id }}" class="bg-neutral-900 text-white" {{ ($filtros['id_tipo_inmueble'] ?? '') == $t->id ? 'selected' : '' }}>
                            {{ $t->nombre }}
                        </option>
                    @endforeach
                </select>
            </div>

            {{-- Divisor --}}
            <div class="hidden md:block w-px h-9 bg-neutral-800"></div>

            {{-- Segmento 2: Municipio --}}
            <div class="w-full md:w-1/3 px-4 py-1 text-left">
                <label for="id_municipio" class="block text-[11px] font-bold uppercase tracking-wider text-neutral-400">
                    Municipio
                </label>
                <select name="id_municipio" id="id_municipio"
                        class="w-full text-sm font-semibold text-white bg-transparent focus:outline-hidden cursor-pointer pt-0.5">
                    <option value="" class="bg-neutral-900 text-white">Todos los municipios</option>
                    @foreach($municipios as $m)
                        <option value="{{ $m->id }}" class="bg-neutral-900 text-white" {{ ($filtros['id_municipio'] ?? '') == $m->id ? 'selected' : '' }}>
                            {{ $m->nombre }}
                        </option>
                    @endforeach
                </select>
            </div>

            {{-- Divisor --}}
            <div class="hidden md:block w-px h-9 bg-neutral-800"></div>

            {{-- Segmento 3: Zona (Rural / Urbana) --}}
            <div class="w-full md:w-1/4 px-4 py-1 text-left">
                <label for="zona" class="block text-[11px] font-bold uppercase tracking-wider text-neutral-400">
                    Zona
                </label>
                <select name="zona" id="zona"
                        class="w-full text-sm font-semibold text-white bg-transparent focus:outline-hidden cursor-pointer pt-0.5">
                    <option value="" class="bg-neutral-900 text-white">Todas las zonas</option>
                    <option value="urbana" class="bg-neutral-900 text-white" {{ ($filtros['zona'] ?? '') === 'urbana' ? 'selected' : '' }}>Urbana</option>
                    <option value="rural" class="bg-neutral-900 text-white" {{ ($filtros['zona'] ?? '') === 'rural' ? 'selected' : '' }}>Rural</option>
                </select>
            </div>

            {{-- Botón Azul Redondeado Tipo Píldora --}}
            <button type="submit"
                    class="w-full md:w-auto px-8 py-3.5 rounded-full bg-blue-600 hover:bg-blue-500 text-white font-bold text-sm shadow-lg shadow-blue-600/40 transition transform hover:scale-102 cursor-pointer shrink-0">
                Buscar
            </button>
        </form>

        {{-- Indicador animado para deslizar --}}
        <a href="#inmuebles"
           class="mt-12 inline-flex flex-col items-center gap-1.5 text-neutral-400 hover:text-white text-xs font-semibold tracking-wide transition animate-bounce cursor-pointer">
            <span>Desliza para ver los inmuebles</span>
            <svg class="w-5 h-5 text-neutral-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 14l-7 7m0 0l-7-7m7 7V3" />
            </svg>
        </a>

    </div>
</section>
@endsection

@section('content')

{{-- SECCIÓN DE CATÁLOGO DE INMUEBLES --}}
<div id="inmuebles" class="scroll-mt-20 pt-4">

    @php
        $hayFiltros = !empty($filtros['tipo_oferta']) || !empty($filtros['zona']) || !empty($filtros['id_municipio']) || !empty($filtros['id_tipo_inmueble']);
    @endphp

    {{-- Encabezado del catálogo en tonos oscuros --}}
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-8 pb-4 border-b border-neutral-800">
        <div>
            <h2 class="text-2xl sm:text-3xl font-extrabold text-white tracking-tight">
                @if(($filtros['tipo_oferta'] ?? '') === 'venta')
                    Inmuebles en Venta
                @elseif(($filtros['tipo_oferta'] ?? '') === 'arriendo')
                    Inmuebles en Arriendo
                @else
                    Inmuebles disponibles
                @endif
            </h2>
            <p class="text-sm text-neutral-400 mt-1">Haz clic en cualquier propiedad para ver sus fotografías y detalles completos.</p>
        </div>

        <div class="flex items-center gap-3 self-start sm:self-auto">
            @if($hayFiltros)
                <a href="{{ route('inicio') }}#inmuebles"
                   class="inline-flex items-center gap-1.5 text-xs font-semibold text-neutral-300 hover:text-white bg-neutral-900 border border-neutral-700 px-3 py-2 rounded-xl transition">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                    <span>Limpiar filtros</span>
                </a>
            @endif

            <span class="text-xs font-bold text-neutral-300 bg-neutral-900 border border-neutral-800 px-3.5 py-2 rounded-xl shadow-xs">
                {{ $inmuebles->total() }} propiedades
            </span>
        </div>
    </div>

    {{-- Cuadrícula de inmuebles --}}
    @if ($inmuebles->isEmpty())
        <div class="bg-neutral-900 border border-neutral-800 rounded-3xl p-12 text-center shadow-xl max-w-lg mx-auto">
            <div class="w-16 h-16 mx-auto rounded-full bg-blue-950/60 text-blue-400 border border-blue-900/50 flex items-center justify-center mb-4">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                </svg>
            </div>
            <h3 class="text-lg font-bold text-white">No encontramos inmuebles con estos criterios</h3>
            <p class="text-sm text-neutral-400 mt-1">Prueba seleccionando otro municipio, tipo de inmueble o limpia los filtros.</p>
            <div class="mt-6">
                <a href="{{ route('inicio') }}#inmuebles"
                   class="inline-flex items-center gap-2 px-5 py-2.5 rounded-full bg-blue-600 hover:bg-blue-500 text-white text-xs font-bold shadow-lg shadow-blue-600/30 transition">
                    Ver todas las propiedades
                </a>
            </div>
        </div>
    @else
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach ($inmuebles as $inmueble)
                <x-publico.tarjeta-inmueble :inmueble="$inmueble" />
            @endforeach
        </div>

        <div class="mt-12">
            {{ $inmuebles->links() }}
        </div>
    @endif

</div>

@endsection
