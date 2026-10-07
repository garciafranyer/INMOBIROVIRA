@extends('layouts.app')

@section('title')
    Agregar imágenes
@endsection

@section('content')

@php
    $input = 'w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-400 focus:border-indigo-400';
    $label = 'block mb-1.5 text-sm font-semibold text-gray-700';
@endphp

<x-card>

    <div class="max-w-2xl mx-auto p-4 sm:p-6">

        <div class="mb-6">
            <h2 class="text-2xl font-bold text-gray-800">Agregar imágenes</h2>
            <p class="text-sm text-gray-500">Elige el inmueble y selecciona una o varias fotos (máximo 10, de 2 MB cada una).</p>
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

        <form action="{{ route('imagen.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
            @csrf

            <section class="bg-white border border-gray-200 rounded-xl shadow-sm p-5 sm:p-6 space-y-4">

                <div>
                    <label class="{{ $label }}">Inmueble</label>
                    <select name="id_inmueble" class="{{ $input }}">
                        @foreach ($inmueble as $item)
                            <option value="{{ $item->id }}" @selected(old('id_inmueble') == $item->id)>{{ $item->nombre }}</option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="{{ $label }}">Imágenes</label>
                    <input type="file" name="imagenes[]" id="imagenes" multiple accept="image/*"
                           class="{{ $input }}">
                </div>

                {{-- Vista previa --}}
                <div id="vista-previa" class="grid grid-cols-3 sm:grid-cols-4 gap-3"></div>

            </section>

            <div class="flex items-center justify-end gap-3">
                <a href="{{ route('imagen.index') }}"
                   class="px-5 py-2.5 rounded-lg border border-gray-300 text-gray-700 hover:bg-gray-50 font-medium transition">
                    Cancelar
                </a>
                <button type="submit"
                        class="px-6 py-2.5 rounded-lg bg-indigo-600 hover:bg-indigo-700 text-white font-semibold shadow transition">
                    Guardar
                </button>
            </div>

        </form>
    </div>

</x-card>

<script>
    document.getElementById('imagenes').addEventListener('change', function () {
        const contenedor = document.getElementById('vista-previa');
        contenedor.innerHTML = '';

        Array.from(this.files).forEach(function (archivo) {
            const img = document.createElement('img');
            img.src = URL.createObjectURL(archivo);
            img.className = 'w-full h-24 object-cover rounded-lg border';
            contenedor.appendChild(img);
        });
    });
</script>

@endsection