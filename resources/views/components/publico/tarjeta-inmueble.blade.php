@props(['inmueble'])

@php
    $d = $inmueble->detalle_inmueble;
    $foto = $inmueble->imagenes->first();
@endphp

<a href="{{ route('propiedad.show', $inmueble->id) }}"
   class="bg-white border border-gray-200 rounded-xl shadow-sm overflow-hidden hover:shadow-md transition flex flex-col">

    @if ($foto)
        <img src="{{ asset('storage/' . $foto->url_imagen) }}" alt="{{ $inmueble->nombre }}" class="w-full h-48 object-cover">
    @else
        <div class="w-full h-48 bg-gray-100 flex items-center justify-center text-gray-400 text-sm">Sin foto</div>
    @endif

    <div class="p-4 flex-1 flex flex-col gap-2">
        <div class="flex items-center gap-2 text-xs">
            <span class="px-2.5 py-1 rounded-full bg-indigo-100 text-indigo-700 font-semibold">{{ ucfirst($d->tipo_oferta) }}</span>
            <span class="text-gray-500">{{ $inmueble->tipo_inmueble?->nombre }}</span>
        </div>

        <h2 class="font-bold text-lg text-gray-800">{{ $inmueble->nombre }}</h2>
        <p class="text-sm text-gray-500">{{ $inmueble->municipio?->nombre }} · {{ $d->direccion }}</p>

        <p class="text-xl font-bold text-indigo-600">${{ number_format($d->precio, 0, ',', '.') }}</p>

        <div class="flex gap-4 text-sm text-gray-600 mt-auto pt-2 border-t">
            <span>{{ $d->numero_habitacion ?? '-' }} hab.</span>
            <span>{{ $d->numero_bano ?? '-' }} baños</span>
            <span>{{ $d->area }} m²</span>
        </div>
    </div>
</a>