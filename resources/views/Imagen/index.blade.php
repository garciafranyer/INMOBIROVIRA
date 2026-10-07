@extends('layouts.app')

@section('title')
    Imágenes
@endsection

@section('content')

<x-card>

    <div class="max-w-7xl mx-auto p-4 sm:p-6">

        {{-- Encabezado --}}
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-6">
            <div>
                <h2 class="text-2xl font-bold text-gray-800">Imágenes de inmuebles</h2>
                <p class="text-sm text-gray-500">Consulta, agrega o elimina las fotos de cada inmueble.</p>
            </div>

            <a href="{{ route('imagen.create') }}"
               class="inline-flex items-center justify-center gap-2 bg-indigo-600 hover:bg-indigo-700 text-white font-semibold px-5 py-2.5 rounded-lg shadow transition">
                <span class="text-lg leading-none">+</span> Agregar imágenes
            </a>
        </div>

        {{-- Mensaje de éxito --}}
        @if (session('success'))
            <div class="bg-green-50 border border-green-300 text-green-700 px-4 py-3 rounded-lg mb-6">
                {{ session('success') }}
            </div>
        @endif

        {{-- Galería --}}
        @if ($imagen->isEmpty())
            <div class="bg-white border border-gray-200 rounded-xl p-10 text-center text-gray-500">
                Aún no hay imágenes registradas.
            </div>
        @else
            <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-4 gap-4">
                @foreach ($imagen as $item)
                    <div class="bg-white border border-gray-200 rounded-xl shadow-sm overflow-hidden flex flex-col">

                        <a href="{{ asset('storage/' . $item->ruta) }}" target="_blank">
                            <img src="{{ asset('storage/' . $item->ruta) }}"
                                 alt="Imagen de {{ $item->inmueble?->nombre }}"
                                 class="w-full h-40 object-cover hover:opacity-90 transition">
                        </a>

                        <div class="p-3 flex-1 flex flex-col justify-between gap-3">
                            <div>
                                <p class="text-xs text-gray-500">Inmueble</p>
                                <p class="font-semibold text-gray-800 truncate">
                                    {{ $item->inmueble?->nombre ?? 'Sin inmueble' }}
                                </p>
                            </div>

                            <form action="{{ route('imagen.destroy', $item->id) }}" method="POST"
                                  onsubmit="return confirm('¿Seguro que quieres eliminar esta imagen?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit"
                                        class="w-full px-3 py-1.5 rounded-lg bg-red-100 text-red-700 hover:bg-red-200 font-medium text-sm transition">
                                    Eliminar
                                </button>
                            </form>
                        </div>

                    </div>
                @endforeach
            </div>
        @endif

    </div>

</x-card>

@endsection