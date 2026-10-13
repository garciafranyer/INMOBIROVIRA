@extends('layouts.app')


@section('title')
    TITULO
@endsection


@section('content')


<x-card>

    <div class="max-w-4xl mx-auto p-4 sm:p-6">

        <div>

            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-6">
                <h2 class="text-2xl font-bold text-gray-800">Listado de los tipos de inmuebles</h2>
                <br>

                <a href="{{ route('tipo_inmueble.create') }}"
                   class="inline-flex items-center justify-center gap-2 bg-indigo-600 hover:bg-indigo-700 text-white font-semibold px-5 py-2.5 rounded-lg shadow transition">
                    Nuevo tipo de inmueble
                </a>
            </div>

            @if(session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                    {{ session('success') }}
                </div>
            @endif

            <div class="overflow-x-auto bg-white border border-gray-200 rounded-xl shadow-sm">
            <table class="min-w-full text-sm text-left">
                <thead class="bg-gray-50 text-gray-600 uppercase text-xs tracking-wider">
                    <tr>
                        <th class="px-4 py-3">Id</th>
                        <th class="px-4 py-3">tipo de inmueble</th>
                        <th class="px-4 py-3 text-center">Editar</th>
                        <th class="px-4 py-3 text-center">Eliminar</th>
                    </tr>
                </thead>

                <tbody class="divide-y divide-gray-100">
                    @foreach ($tipo_inmueble as $tipoInmueble)
                        <tr class="hover:bg-gray-50 transition">
                            <td class="px-4 py-3 text-gray-500">{{ $tipoInmueble->id }}</td>
                            <td class="px-4 py-3 font-semibold text-gray-800">{{ $tipoInmueble->nombre }}</td>

                            <td class="px-4 py-3 text-center">
                                <a href="{{ route('tipo_inmueble.edit', $tipoInmueble->id) }}"
                                   class="inline-block px-3 py-1.5 rounded-lg bg-amber-100 text-amber-800 hover:bg-amber-200 font-medium transition">
                                    Editar
                                </a>
                            </td>

                            <td class="px-4 py-3 text-center">
                                <form action="{{ route('tipo_inmueble.destroy', $tipoInmueble->id) }}" method="POST">
                                    @csrf
                                    @method('DELETE')

                                    <button type="submit"
                                            class="px-3 py-1.5 rounded-lg bg-red-100 text-red-700 hover:bg-red-200 font-medium transition">
                                        Eliminar
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>

            </table>
            </div>

        </div>

    </div>

</x-card>

@endsection