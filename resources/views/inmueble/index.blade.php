@extends('layouts.app')

@section('title')
    Listado de inmuebles
@endsection

@section('content')

@php
    $badge = fn ($estado) => match ($estado) {
        'disponible' => 'bg-green-100 text-green-700',
        'arrendado'  => 'bg-blue-100 text-blue-700',
        'vendido'    => 'bg-purple-100 text-purple-700',
        'reservado'  => 'bg-yellow-100 text-yellow-700',
        default      => 'bg-gray-100 text-gray-600',
    };
@endphp

<x-card>

    <div class="max-w-7xl mx-auto p-4 sm:p-6">

        {{-- Encabezado --}}
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-6">
            <div>
                <h2 class="text-2xl font-bold text-gray-800">Listado de inmuebles</h2>
                <p class="text-sm text-gray-500">Administra los inmuebles y consulta sus detalles.</p>
            </div>

            <a href="{{ route('inmueble.create') }}"
            class="inline-flex items-center justify-center gap-2 bg-indigo-600 hover:bg-indigo-700 text-white font-semibold px-5 py-2.5 rounded-lg shadow transition">
                <span class="text-lg leading-none">+</span> Nuevo inmueble
            </a>
        </div>

        {{-- Mensaje de éxito --}}
        @if (session('success'))
            <div class="bg-green-50 border border-green-300 text-green-700 px-4 py-3 rounded-lg mb-6">
                {{ session('success') }}
            </div>
        @endif

        {{-- Tabla --}}
        <div class="overflow-x-auto bg-white border border-gray-200 rounded-xl shadow-sm">
            <table class="min-w-full text-sm text-left">
                <thead class="bg-gray-50 text-gray-600 uppercase text-xs tracking-wider">
                    <tr>
                        <th class="px-4 py-3">Id</th>
                        <th class="px-4 py-3">Nombre</th>
                        <th class="px-4 py-3">Zona</th>
                        <th class="px-4 py-3">Usuario</th>
                        <th class="px-4 py-3">Tipo</th>
                        <th class="px-4 py-3">Municipio</th>
                        <th class="px-4 py-3 text-center">Acciones</th>
                    </tr>
                </thead>

                <tbody class="divide-y divide-gray-100">
                    @forelse ($inmueble as $item)
                        <tr class="hover:bg-gray-50 transition">
                            <td class="px-4 py-3 text-gray-500">{{ $item->id }}</td>
                            <td class="px-4 py-3 font-semibold text-gray-800">{{ $item->nombre }}</td>
                            <td class="px-4 py-3">
                                <span class="px-2.5 py-1 rounded-full text-xs font-medium {{ $item->zona === 'urbana' ? 'bg-sky-100 text-sky-700' : 'bg-emerald-100 text-emerald-700' }}">
                                    {{ ucfirst($item->zona) }}
                                </span>
                            </td>
                            <td class="px-4 py-3">{{ $item->usuario?->nombre }}</td>
                            <td class="px-4 py-3">{{ $item->tipo_inmueble?->nombre }}</td>
                            <td class="px-4 py-3">{{ $item->municipio?->nombre }}</td>

                            <td class="px-4 py-3">
                                <div class="flex items-center justify-center gap-2">
                                    <button type="button"
                                            data-id="{{ $item->id }}"
                                            class="px-3 py-1.5 rounded-lg border border-indigo-300 text-indigo-700 hover:bg-indigo-50 font-medium transition">
                                        Ver detalles
                                    </button>

                                    <a href="{{ route('inmueble.edit', $item->id) }}"
                                    class="px-3 py-1.5 rounded-lg bg-amber-100 text-amber-800 hover:bg-amber-200 font-medium transition">
                                        Editar
                                    </a>

                                    <form action="{{ route('inmueble.destroy', $item->id) }}" method="POST"
                                        onsubmit="return confirm('¿Seguro que quieres eliminar este inmueble?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                                class="px-3 py-1.5 rounded-lg bg-red-100 text-red-700 hover:bg-red-200 font-medium transition">
                                            Eliminar
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>

                        {{-- Fila de detalles (oculta por defecto) --}}
                        <tr id="detalle-{{ $item->id }}" style="display: none;" class="bg-indigo-50/40">
                            <td colspan="7" class="px-6 py-5">
                                @if ($item->detalle_inmueble)
                                    @php $d = $item->detalle_inmueble; @endphp

                                    <div class="flex flex-wrap items-center gap-3 mb-4">
                                        <span class="px-3 py-1 rounded-full text-xs font-semibold bg-indigo-100 text-indigo-700">
                                            {{ ucfirst($d->tipo_oferta) }}
                                        </span>
                                        <span class="px-3 py-1 rounded-full text-xs font-semibold {{ $badge($d->estado_publicacion) }}">
                                            {{ ucfirst($d->estado_publicacion) }}
                                        </span>
                                        <span class="text-sm text-gray-500">Publicado el {{ $d->fecha_publicacion }}</span>
                                    </div>

                                    <p class="text-gray-700 mb-4">
                                        <span class="font-semibold">Dirección:</span> {{ $d->direccion }}
                                    </p>

                                    <div class="grid grid-cols-2 md:grid-cols-4 gap-3">
                                        <div class="bg-white border rounded-lg p-3">
                                            <p class="text-xs text-gray-500">Precio</p>
                                            <p class="font-bold text-gray-800">${{ number_format($d->precio, 0, ',', '.') }}</p>
                                        </div>
                                        <div class="bg-white border rounded-lg p-3">
                                            <p class="text-xs text-gray-500">Administración</p>
                                            <p class="font-bold text-gray-800">${{ number_format($d->precio_administrador, 0, ',', '.') }}</p>
                                        </div>
                                        <div class="bg-white border rounded-lg p-3">
                                            <p class="text-xs text-gray-500">Área</p>
                                            <p class="font-bold text-gray-800">{{ $d->area }} m²</p>
                                        </div>
                                        <div class="bg-white border rounded-lg p-3">
                                            <p class="text-xs text-gray-500">Habitaciones</p>
                                            <p class="font-bold text-gray-800">{{ $d->numero_habitacion ?? '-' }}</p>
                                        </div>
                                        <div class="bg-white border rounded-lg p-3">
                                            <p class="text-xs text-gray-500">Baños</p>
                                            <p class="font-bold text-gray-800">{{ $d->numero_bano ?? '-' }}</p>
                                        </div>
                                        <div class="bg-white border rounded-lg p-3">
                                            <p class="text-xs text-gray-500">Parqueaderos</p>
                                            <p class="font-bold text-gray-800">{{ $d->numero_parqueadero ?? '-' }}</p>
                                        </div>
                                        <div class="bg-white border rounded-lg p-3">
                                            <p class="text-xs text-gray-500">Piso</p>
                                            <p class="font-bold text-gray-800">{{ $d->numero_piso ?? '-' }}</p>
                                        </div>
                                        <div class="bg-white border rounded-lg p-3">
                                            <p class="text-xs text-gray-500">Apartamento</p>
                                            <p class="font-bold text-gray-800">{{ $d->numero_apartamento ?? '-' }}</p>
                                        </div>
                                    </div>

                                    <p class="mt-4 text-gray-600 italic">{{ $d->descripcion }}</p>
                                @else
                                    <p class="text-gray-500">Este inmueble no tiene detalles.</p>
                                @endif

                                {{-- Imágenes del inmueble --}}
                                @if ($item->imagenes->isNotEmpty())
                                    <div class="flex flex-wrap gap-3 mt-4">
                                        @foreach ($item->imagenes as $img)
                                            <a href="{{ asset('storage/' . $img->url_imagen) }}" target="_blank">
                                            <img src="{{ asset('storage/' . $img->url_imagen) }}" class="w-28 h-20 object-cover rounded-lg border">
                                            </a>
                                        @endforeach
                                    </div>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="px-4 py-10 text-center text-gray-500">
                                Aún no hay inmuebles registrados.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

    </div>

</x-card>

<script>
    function toggleDetalle(id, boton) {
        const fila = document.getElementById('detalle-' + id);
        const oculto = fila.style.display === 'none';
        fila.style.display = oculto ? 'table-row' : 'none';
        boton.textContent = oculto ? 'Ocultar detalles' : 'Ver detalles';
    }
</script>

@endsection