@extends('layouts.app')

@section('title')
    Listado de municipios
@endsection

@section('content')

<x-card>

    <div class="max-w-5xl mx-auto p-4 sm:p-6">

        {{-- Encabezado --}}
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-6">
            <div>
                <h2 class="text-2xl font-bold text-gray-800">Listado de municipios</h2>
                <p class="text-sm text-gray-500">Administra los municipios y sus códigos postales.</p>
            </div>

            <a href="{{ route('municipio.create') }}"
               class="inline-flex items-center justify-center gap-2 bg-indigo-600 hover:bg-indigo-700 text-white font-semibold px-5 py-2.5 rounded-lg shadow transition">
                <span class="text-lg leading-none">+</span> Nuevo municipio
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
                        <th class="px-4 py-3">Nombre del municipio</th>
                        <th class="px-4 py-3">Código postal</th>
                        <th class="px-4 py-3 text-center">Acciones</th>
                    </tr>
                </thead>

                <tbody class="divide-y divide-gray-100">
                    @forelse ($municipio as $item)
                        <tr class="hover:bg-gray-50 transition">
                            <td class="px-4 py-3 text-gray-500">{{ $item->id }}</td>
                            <td class="px-4 py-3 font-semibold text-gray-800">{{ $item->nombre }}</td>
                            <td class="px-4 py-3">
                                <span class="px-2.5 py-1 rounded-full text-xs font-medium bg-indigo-100 bg-indigo-200 ">
                                    {{ $item->codigo_postal }}
                                </span>
                            </td>

                            <td class="px-4 py-3">
                                <div class="flex items-center justify-center gap-2">
                                    <a href="{{ route('municipio.edit', $item->id) }}"
                                       class="px-3 py-1.5 rounded-lg bg-amber-100 text-amber-800 hover:bg-amber-200 font-medium transition">
                                        Editar
                                    </a>

                                    <form action="{{ route('municipio.destroy', $item->id) }}" method="POST"
                                          onsubmit="return confirm('¿Seguro que quieres eliminar este municipio?')">
                                        @csrf
                                        @method('DELETE')

                                        <button type="submit"
                                                class="px-3 py-1.5 rounded-lg bg-red-100 text-red-700 hover:bg-red-100 font-medium transition">
                                            Eliminar
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="px-4 py-10 text-center text-gray-500">
                                Aún no hay municipios registrados.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

    </div>

</x-card>

@endsection