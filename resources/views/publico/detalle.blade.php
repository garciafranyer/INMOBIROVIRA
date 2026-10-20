@extends('layouts.publico')

@section('title', $inmueble->nombre)

@section('content')

@php
    $d = $inmueble->detalle_inmueble;
    $telefono = preg_replace('/\D/', '', $inmueble->usuario?->telefono ?? '');
@endphp

<a href="{{ route('inicio') }}" class="text-sm text-indigo-600 hover:underline">&larr; Volver al listado</a>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-8 mt-4">

    {{-- Galería --}}
    <div class="lg:col-span-2">
        @if ($inmueble->imagenes->isNotEmpty())
            <div class="grid grid-cols-2 sm:grid-cols-3 gap-3">
                @foreach ($inmueble->imagenes as $img)
                    <a href="{{ asset('storage/' . $img->url_imagen) }}" target="_blank"
                       class="{{ $loop->first ? 'col-span-2 sm:col-span-3' : '' }}">
                        <img src="{{ asset('storage/' . $img->url_imagen) }}"
                             alt="{{ $inmueble->nombre }}"
                             class="w-full {{ $loop->first ? 'h-96' : 'h-40' }} object-cover rounded-xl border hover:opacity-90 transition">
                    </a>
                @endforeach
            </div>
        @else
            <div class="w-full h-96 bg-gray-100 rounded-xl flex items-center justify-center text-gray-400">Sin fotos</div>
        @endif

        <div class="mt-8 bg-white border border-gray-200 rounded-xl p-6">
            <h2 class="text-lg font-bold mb-2">Descripción</h2>
            <p class="text-gray-600">{{ $d->descripcion }}</p>
        </div>
    </div>

    {{-- Información --}}
    <div class="space-y-6">
        <div class="bg-white border border-gray-200 rounded-xl p-6 shadow-sm">
            <div class="flex items-center gap-2 text-xs mb-2">
                <span class="px-2.5 py-1 rounded-full bg-indigo-100 text-indigo-700 font-semibold">{{ ucfirst($d->tipo_oferta) }}</span>
                <span class="text-gray-500">{{ $inmueble->tipo_inmueble?->nombre }}</span>
            </div>

            <h1 class="text-2xl font-bold text-gray-800">{{ $inmueble->nombre }}</h1>
            <p class="text-gray-500 mt-1">{{ $inmueble->municipio?->nombre }} · {{ $d->direccion }}</p>

            <p class="text-3xl font-bold text-indigo-600 mt-4">${{ number_format($d->precio, 0, ',', '.') }}</p>
            <p class="text-sm text-gray-500">Administración: ${{ number_format($d->precio_administrador, 0, ',', '.') }}</p>

            @if ($telefono)
                <a href="https://wa.me/57{{ $telefono }}?text={{ urlencode('Hola, me interesa el inmueble ' . $inmueble->nombre) }}"
                   target="_blank"
                   class="mt-5 block text-center bg-green-500 hover:bg-green-600 text-white font-semibold px-5 py-2.5 rounded-lg shadow transition">
                    Contactar por WhatsApp
                </a>
            @endif
        </div>

        <div class="bg-white border border-gray-200 rounded-xl p-6 shadow-sm">
            <h2 class="text-lg font-bold mb-3">Características</h2>
            <dl class="grid grid-cols-2 gap-3 text-sm">
                <div><dt class="text-gray-500">Área</dt><dd class="font-semibold">{{ $d->area }} m²</dd></div>
                <div><dt class="text-gray-500">Habitaciones</dt><dd class="font-semibold">{{ $d->numero_habitacion ?? '-' }}</dd></div>
                <div><dt class="text-gray-500">Baños</dt><dd class="font-semibold">{{ $d->numero_bano ?? '-' }}</dd></div>
                <div><dt class="text-gray-500">Parqueaderos</dt><dd class="font-semibold">{{ $d->numero_parqueadero ?? '-' }}</dd></div>
                <div><dt class="text-gray-500">Piso</dt><dd class="font-semibold">{{ $d->numero_piso ?? '-' }}</dd></div>
                <div><dt class="text-gray-500">Apartamento</dt><dd class="font-semibold">{{ $d->numero_apartamento ?? '-' }}</dd></div>
                <div><dt class="text-gray-500">Zona</dt><dd class="font-semibold">{{ ucfirst($inmueble->zona) }}</dd></div>
                <div><dt class="text-gray-500">Publicado</dt><dd class="font-semibold">{{ $d->fecha_publicacion }}</dd></div>
            </dl>
        </div>
    </div>

</div>

@endsection