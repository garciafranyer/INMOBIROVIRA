@extends('layouts.app')

@section('title')
    Editar inmueble
@endsection

@section('content')

@php
    $input = 'w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-400 focus:border-indigo-400';
    $label = 'block mb-1.5 text-sm font-semibold text-gray-700';
    $d = $inmueble->detalle_inmueble;
@endphp

<x-card>

    <div class="max-w-4xl mx-auto p-4 sm:p-6">

        <div class="mb-6">
            <h2 class="text-2xl font-bold text-gray-800">Editar inmueble</h2>
            <p class="text-sm text-gray-500">Modifica los datos del inmueble, su detalle y sus imágenes.</p>
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

        <form action="{{ route('inmueble.update', $inmueble->id) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
            @csrf
            @method('PUT')

            {{-- DATOS DEL INMUEBLE --}}
            <section class="bg-white border border-gray-200 rounded-xl shadow-sm p-5 sm:p-6">
                <h3 class="text-lg font-bold text-gray-800 mb-4 pb-2 border-b">Datos del inmueble</h3>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div class="md:col-span-2">
                        <label class="{{ $label }}">Nombre del inmueble</label>
                        <input type="text" name="nombre" value="{{ old('nombre', $inmueble->nombre) }}" class="{{ $input }}">
                    </div>

                    <div>
                        <label class="{{ $label }}">Zona</label>
                        <select name="zona" id="zona" class="{{ $input }}">
                            <option value="rural" @selected(old('zona', $inmueble->zona) === 'rural')>Rural</option>
                            <option value="urbana" @selected(old('zona', $inmueble->zona) === 'urbana')>Urbana</option>
                        </select>
                    </div>

                    <div>
                        <label class="{{ $label }}">Usuario</label>
                        <select name="id_usuario" class="{{ $input }}">
                            @foreach ($usuario as $u)
                                <option value="{{ $u->id }}" @selected(old('id_usuario', $inmueble->id_usuario) == $u->id)>{{ $u->nombre }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label class="{{ $label }}">Tipo de inmueble</label>
                        <select name="id_tipo_inmueble" class="{{ $input }}">
                            @foreach ($tipo_inmueble as $tipo)
                                <option value="{{ $tipo->id }}" @selected(old('id_tipo_inmueble', $inmueble->id_tipo_inmueble) == $tipo->id)>{{ $tipo->nombre }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label class="{{ $label }}">Municipio</label>
                        <select name="id_municipio" class="{{ $input }}">
                            @foreach ($municipios as $municipio)
                                <option value="{{ $municipio->id }}" @selected(old('id_municipio', $inmueble->id_municipio) == $municipio->id)>{{ $municipio->nombre }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </section>

            {{-- DETALLE DEL INMUEBLE --}}
            <section class="bg-white border border-gray-200 rounded-xl shadow-sm p-5 sm:p-6">
                <h3 class="text-lg font-bold text-gray-800 mb-4 pb-2 border-b">Detalle del inmueble</h3>

                @unless ($d)
                    <p class="mb-4 text-sm text-amber-700 bg-amber-50 border border-amber-200 rounded-lg px-3 py-2">
                        Este inmueble aún no tiene detalle. Al guardar se creará con los datos de abajo.
                    </p>
                @endunless

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div class="md:col-span-2">
                        <label class="{{ $label }}">Dirección</label>
                        <input type="text" name="detalle[direccion]" value="{{ old('detalle.direccion', $d->direccion ?? '') }}" class="{{ $input }}">
                    </div>

                    <div>
                        <label class="{{ $label }}">Tipo de oferta</label>
                        <select name="detalle[tipo_oferta]" class="{{ $input }}">
                            @foreach (['venta', 'arriendo', 'venta y arriendo'] as $oferta)
                                <option value="{{ $oferta }}" @selected(old('detalle.tipo_oferta', $d->tipo_oferta ?? '') === $oferta)>{{ ucfirst($oferta) }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label class="{{ $label }}">Estado de publicación</label>
                        <select name="detalle[estado_publicacion]" class="{{ $input }}">
                            @foreach (['disponible', 'arrendado', 'vendido', 'reservado', 'inactivo'] as $estado)
                                <option value="{{ $estado }}" @selected(old('detalle.estado_publicacion', $d->estado_publicacion ?? '') === $estado)>{{ ucfirst($estado) }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label class="{{ $label }}">Precio</label>
                        <input type="number" step="0.01" name="detalle[precio]" value="{{ old('detalle.precio', $d->precio ?? '') }}" class="{{ $input }}">
                    </div>

                    <div>
                        <label class="{{ $label }}">Precio de administración</label>
                        <input type="number" step="0.01" name="detalle[precio_administrador]" value="{{ old('detalle.precio_administrador', $d->precio_administrador ?? '') }}" class="{{ $input }}">
                    </div>

                    <div>
                        <label class="{{ $label }}">Área (m²)</label>
                        <input type="number" step="0.01" name="detalle[area]" value="{{ old('detalle.area', $d->area ?? '') }}" class="{{ $input }}">
                    </div>

                    <div>
                        <label class="{{ $label }}">Fecha de publicación</label>
                        <input type="date" name="detalle[fecha_publicacion]" value="{{ old('detalle.fecha_publicacion', $d->fecha_publicacion ?? '') }}" class="{{ $input }}">
                    </div>

                    <div>
                        <label class="{{ $label }}">Habitaciones</label>
                        <input type="number" name="detalle[numero_habitacion]" value="{{ old('detalle.numero_habitacion', $d->numero_habitacion ?? '') }}" class="{{ $input }}">
                    </div>

                    <div>
                        <label class="{{ $label }}">Baños</label>
                        <input type="number" name="detalle[numero_bano]" value="{{ old('detalle.numero_bano', $d->numero_bano ?? '') }}" class="{{ $input }}">
                    </div>

                    <div>
                        <label class="{{ $label }}">Parqueaderos</label>
                        <input type="number" name="detalle[numero_parqueadero]" value="{{ old('detalle.numero_parqueadero', $d->numero_parqueadero ?? '') }}" class="{{ $input }}">
                    </div>

                    <div>
                        <label class="{{ $label }}">Piso</label>
                        <input type="number" name="detalle[numero_piso]" value="{{ old('detalle.numero_piso', $d->numero_piso ?? '') }}" class="{{ $input }}">
                    </div>

                    <div>
                        <label class="{{ $label }}">Apartamento</label>
                        <input type="number" name="detalle[numero_apartamento]" value="{{ old('detalle.numero_apartamento', $d->numero_apartamento ?? '') }}" class="{{ $input }}">
                    </div>

                    <div class="md:col-span-2">
                        <label class="{{ $label }}">Descripción</label>
                        <input type="text" name="detalle[descripcion]" value="{{ old('detalle.descripcion', $d->descripcion ?? '') }}" class="{{ $input }}">
                    </div>
                </div>
            </section>

            {{-- IMÁGENES --}}
            <section class="bg-white border border-gray-200 rounded-xl shadow-sm p-5 sm:p-6">
                <h3 class="text-lg font-bold text-gray-800 mb-4 pb-2 border-b">Imágenes</h3>

                @if ($inmueble->imagenes->isNotEmpty())
                    <div class="grid grid-cols-2 sm:grid-cols-4 gap-3 mb-4">
                        @foreach ($inmueble->imagenes as $img)
                            <div class="border rounded-lg p-2 text-center">
                                <img src="{{ asset('storage/' . $img->ruta) }}" class="w-full h-24 object-cover rounded">
                                <button type="submit" form="eliminar-imagen-{{ $img->id }}"
                                        onclick="return confirm('¿Eliminar esta imagen?')"
                                        class="mt-2 text-sm text-red-600 hover:underline">
                                    Eliminar
                                </button>
                            </div>
                        @endforeach
                    </div>
                @endif

                <label class="{{ $label }}">Agregar más imágenes</label>
                <input type="file" name="imagenes[]" id="imagenes" multiple accept="image/*" class="{{ $input }}">
                <p class="mt-2 text-xs text-gray-500">Máximo 10 fotos por vez, de 2 MB cada una.</p>

                <div id="vista-previa" class="grid grid-cols-3 sm:grid-cols-4 gap-3 mt-4"></div>
            </section>

            {{-- Botones --}}
            <div class="flex items-center justify-end gap-3">
                <a href="{{ route('inmueble.index') }}"
                   class="px-5 py-2.5 rounded-lg border border-gray-300 text-gray-700 hover:bg-gray-50 font-medium transition">
                    Cancelar
                </a>
                <button type="submit"
                        class="px-6 py-2.5 rounded-lg bg-indigo-600 hover:bg-indigo-700 text-white font-semibold shadow transition">
                    Guardar cambios
                </button>
            </div>

        </form>

        {{-- Formularios ocultos para borrar imágenes (fuera del formulario principal) --}}
        @foreach ($inmueble->imagenes as $img)
            <form id="eliminar-imagen-{{ $img->id }}" action="{{ route('imagen.destroy', $img->id) }}" method="POST" class="hidden">
                @csrf
                @method('DELETE')
            </form>
        @endforeach

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