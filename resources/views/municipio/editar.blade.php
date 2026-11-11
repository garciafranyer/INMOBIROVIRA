@extends('layouts.app')

@section('title')
    Editar municipio
@endsection

@section('content')

@php
    $input = 'w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-400 focus:border-indigo-400';
    $label = 'block mb-1.5 text-sm font-semibold text-gray-700';
@endphp

<x-card>

    <div class="max-w-4xl mx-auto p-4 sm:p-6">

        <div class="mb-6">
            <h2 class="text-2xl font-bold text-gray-800">Editar municipio</h2>
            <p class="text-sm text-gray-500">Modifica los datos del municipio {{ $municipio->nombre }}.</p>
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

        <form action="{{ route('municipio.update', $municipio->id) }}" method="POST" class="space-y-6">
            @csrf
            @method('PUT')

            <section class="bg-white border border-gray-200 rounded-xl shadow-sm p-5 sm:p-6">
                <h3 class="text-lg font-bold text-gray-800 mb-4 pb-2 border-b">Datos del municipio</h3>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label for="nombre" class="{{ $label }}">Nombre del municipio</label>
                        <input type="text" name="nombre" id="nombre" value="{{ old('nombre', $municipio->nombre) }}" required class="{{ $input }}">
                    </div>

                    <div>
                        <label for="codigo_postal" class="{{ $label }}">Código postal</label>
                        <input type="text" name="codigo_postal" id="codigo_postal" value="{{ old('codigo_postal', $municipio->codigo_postal) }}" required class="{{ $input }}">
                    </div>
                </div>
            </section>

            {{-- Botones --}}
            <div class="flex items-center justify-end gap-3">
                <a href="{{ route('municipio.index') }}"
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
