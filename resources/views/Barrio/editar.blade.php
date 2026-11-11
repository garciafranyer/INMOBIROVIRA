@extends('layouts.app')

@section('title')
    Editar barrio
@endsection

@section('content')

@php
    $input = 'w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-400 focus:border-indigo-400';
    $label = 'block mb-1.5 text-sm font-semibold text-gray-700';
@endphp

<x-card>

    <div class="max-w-4xl mx-auto p-4 sm:p-6">

        <div class="mb-6">
            <h2 class="text-2xl font-bold text-gray-800">Editar barrio o vereda</h2>
            <p class="text-sm text-gray-500">Modifica los datos del barrio o vereda {{ $barrio->nombre }}.</p>
        </div>

        {{-- Errores --}}
        @if ($errors->any())
            <div class="bg-red-50 border border-red-300 text-red-700 px-4 py-3 rounded-lg mb-6">
                <p class="font-semibold mb-1">Revisa estos campos:</p>
                <ul class="list-disc list-inside text-sm">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('barrio.update', $barrio->id) }}" method="POST" class="space-y-6">
            @csrf
            @method('PUT')

            <section class="bg-white border border-gray-200 rounded-xl shadow-sm p-5 sm:p-6">
                <h3 class="text-lg font-bold text-gray-800 mb-4 pb-2 border-b">Datos del barrio o vereda</h3>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label for="id_municipio" class="{{ $label }}">Municipio</label>
                        <select name="id_municipio" id="id_municipio" required class="{{ $input }}">
                            @foreach ($municipios as $m)
                                <option value="{{ $m->id }}" @selected(old('id_municipio', $barrio->id_municipio) == $m->id)>
                                    {{ $m->nombre }} (CP: {{ $m->codigo_postal }})
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label for="nombre" class="{{ $label }}">Nombre del barrio o vereda</label>
                        <input type="text" name="nombre" id="nombre" value="{{ old('nombre', $barrio->nombre) }}" required class="{{ $input }}">
                    </div>
                </div>
            </section>

            {{-- Botones --}}
            <div class="flex items-center justify-end gap-3">
                <a href="{{ route('barrio.index') }}"
                   class="px-5 py-2.5 rounded-lg border border-gray-300 text-gray-700 hover:bg-gray-50 font-medium transition">
                    Cancelar
                </a>
                <button type="submit"
                        class="px-6 py-2.5 rounded-lg bg-indigo-600 hover:bg-indigo-700 text-white font-semibold shadow transition">
                    Actualizar
                </button>
            </div>

        </form>

    </div>

</x-card>

@endsection
