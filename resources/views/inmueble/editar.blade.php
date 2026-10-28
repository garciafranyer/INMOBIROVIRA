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
                        <label class="{{ $label }}">Estrato</label>
                        <select name="detalle[estrato]" class="{{ $input }}">
                            <option value="">Selecciona estrato</option>
                            @for ($i = 1; $i <= 6; $i++)
                                <option value="{{ $i }}" {{ old('detalle.estrato', $d->estrato ?? '') == $i ? 'selected' : '' }}>Estrato {{ $i }}</option>
                            @endfor
                        </select>
                    </div>

                    <div>
                        <label class="{{ $label }}">¿Admite mascotas? 🐾</label>
                        <select name="detalle[mascotas_permitidas]" class="{{ $input }}">
                            <option value="">Sin especificar</option>
                            <option value="1" {{ old('detalle.mascotas_permitidas', isset($d->mascotas_permitidas) ? (string)(int)$d->mascotas_permitidas : '') === '1' ? 'selected' : '' }}>Sí admite mascotas</option>
                            <option value="0" {{ old('detalle.mascotas_permitidas', isset($d->mascotas_permitidas) ? (string)(int)$d->mascotas_permitidas : '') === '0' ? 'selected' : '' }}>No admite mascotas</option>
                        </select>
                    </div>

                    <div>
                        <label class="{{ $label }}">Antigüedad</label>
                        <select name="detalle[antiguedad]" class="{{ $input }}">
                            <option value="">Selecciona antigüedad</option>
                            <option value="Para estrenar" {{ old('detalle.antiguedad', $d->antiguedad ?? '') == 'Para estrenar' ? 'selected' : '' }}>Para estrenar</option>
                            <option value="1 a 5 años" {{ old('detalle.antiguedad', $d->antiguedad ?? '') == '1 a 5 años' ? 'selected' : '' }}>1 a 5 años</option>
                            <option value="5 a 10 años" {{ old('detalle.antiguedad', $d->antiguedad ?? '') == '5 a 10 años' ? 'selected' : '' }}>5 a 10 años</option>
                            <option value="Más de 10 años" {{ old('detalle.antiguedad', $d->antiguedad ?? '') == 'Más de 10 años' ? 'selected' : '' }}>Más de 10 años</option>
                        </select>
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
                <div class="flex items-center justify-between mb-4 pb-2 border-b">
                    <div>
                        <h3 class="text-lg font-bold text-gray-800">Galería de Imágenes</h3>
                        <p class="text-xs text-gray-500">Administra las fotos actuales o agrega nuevas imágenes al inmueble.</p>
                    </div>
                    <span id="contador-fotos" class="hidden text-xs font-semibold px-2.5 py-1 bg-indigo-50 text-indigo-700 rounded-full border border-indigo-200">
                        0 / 10 fotos nuevas
                    </span>
                </div>

                {{-- Fotos actuales guardadas en base de datos --}}
                @if ($inmueble->imagenes->isNotEmpty())
                    <div class="mb-6">
                        <label class="block text-xs font-bold uppercase tracking-wider text-gray-600 mb-2">
                            Fotos publicadas actualmente ({{ $inmueble->imagenes->count() }})
                        </label>
                        <div class="grid grid-cols-2 sm:grid-cols-4 gap-3">
                            @foreach ($inmueble->imagenes as $img)
                                <div class="relative group rounded-xl overflow-hidden border border-gray-200 bg-white shadow-xs">
                                    <div class="aspect-4/3 w-full bg-gray-100 overflow-hidden relative">
                                        <img src="{{ asset('storage/' . $img->url_imagen) }}" class="w-full h-28 object-cover group-hover:scale-105 transition duration-200">
                                        @if ($loop->first)
                                            <span class="absolute top-2 left-2 bg-amber-500 text-white text-[10px] font-bold px-2 py-0.5 rounded-full shadow-md flex items-center gap-1">
                                                <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                                                Portada
                                            </span>
                                        @endif
                                        <button type="submit"
                                                form="eliminar-imagen-{{ $img->id }}"
                                                onclick="return confirm('¿Eliminar esta imagen del inmueble?')"
                                                class="absolute top-2 right-2 w-7 h-7 bg-red-600/90 hover:bg-red-700 text-white rounded-full flex items-center justify-center shadow-lg transition transform hover:scale-110 cursor-pointer"
                                                title="Eliminar de la galería">
                                            <svg class="w-4 h-4 pointer-events-none" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                        </button>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif

                {{-- Zona de Arrastrar y Soltar para fotos nuevas --}}
                <label class="block text-xs font-bold uppercase tracking-wider text-gray-600 mb-2">
                    Agregar más imágenes
                </label>
                <div id="dropzone"
                     class="relative border-2 border-dashed border-gray-300 hover:border-indigo-500 rounded-xl p-8 text-center bg-gray-50/60 hover:bg-indigo-50/30 transition-all cursor-pointer group">
                    <input type="file"
                           name="imagenes[]"
                           id="imagenes"
                           multiple
                           accept="image/jpeg,image/png,image/webp,image/jpg"
                           class="absolute inset-0 w-full h-full opacity-0 cursor-pointer z-10">

                    <div class="flex flex-col items-center justify-center space-y-2 pointer-events-none">
                        <div class="w-14 h-14 rounded-full bg-indigo-100/80 group-hover:bg-indigo-200/80 text-indigo-600 flex items-center justify-center transition group-hover:scale-110 shadow-xs">
                            <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                            </svg>
                        </div>
                        <p class="text-sm font-semibold text-gray-700 group-hover:text-indigo-600 transition">
                            Arrastra y suelta fotos nuevas aquí, o <span class="text-indigo-600 underline font-bold">haz clic para explorar</span>
                        </p>
                        <p class="text-xs text-gray-500">
                            Hasta 10 fotos nuevas por carga (máx. 5 MB c/u en JPG, PNG o WEBP).
                        </p>
                    </div>
                </div>

                {{-- Vista previa de las fotos nuevas seleccionadas --}}
                <div id="vista-previa" class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 gap-4 mt-5 empty:hidden"></div>
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
    (function () {
        const inputImagenes = document.getElementById('imagenes');
        const dropzone = document.getElementById('dropzone');
        const vistaPrevia = document.getElementById('vista-previa');
        const contadorFotos = document.getElementById('contador-fotos');

        let dt = new DataTransfer();

        ['dragenter', 'dragover'].forEach(eventName => {
            dropzone.addEventListener(eventName, (e) => {
                e.preventDefault();
                e.stopPropagation();
                dropzone.classList.add('border-indigo-600', 'bg-indigo-50/70', 'ring-2', 'ring-indigo-400');
            }, false);
        });

        ['dragleave', 'drop'].forEach(eventName => {
            dropzone.addEventListener(eventName, (e) => {
                e.preventDefault();
                e.stopPropagation();
                dropzone.classList.remove('border-indigo-600', 'bg-indigo-50/70', 'ring-2', 'ring-indigo-400');
            }, false);
        });

        dropzone.addEventListener('drop', (e) => {
            procesarArchivos(e.dataTransfer.files);
        });

        inputImagenes.addEventListener('change', function () {
            procesarArchivos(this.files);
        });

        function procesarArchivos(nuevosArchivos) {
            Array.from(nuevosArchivos).forEach(archivo => {
                if (!archivo.type.startsWith('image/')) return;
                if (dt.items.length >= 10) return;

                const yaExiste = Array.from(dt.files).some(f => f.name === archivo.name && f.size === archivo.size);
                if (!yaExiste) {
                    dt.items.add(archivo);
                }
            });

            inputImagenes.files = dt.files;
            renderizarVistaPrevia();
        }

        function renderizarVistaPrevia() {
            vistaPrevia.innerHTML = '';
            const archivos = Array.from(dt.files);

            if (archivos.length > 0) {
                contadorFotos.classList.remove('hidden');
                contadorFotos.textContent = `${archivos.length} / 10 fotos nuevas seleccionadas`;
            } else {
                contadorFotos.classList.add('hidden');
            }

            archivos.forEach((archivo, index) => {
                const card = document.createElement('div');
                card.className = 'relative group rounded-xl overflow-hidden border border-gray-200 bg-white shadow-xs';

                const url = URL.createObjectURL(archivo);
                const kb = (archivo.size / 1024).toFixed(0);
                const mb = (archivo.size / (1024 * 1024)).toFixed(1);
                const pesoTexto = archivo.size > 1024 * 1024 ? `${mb} MB` : `${kb} KB`;

                card.innerHTML = `
                    <div class="aspect-4/3 w-full bg-gray-100 overflow-hidden relative">
                        <img src="${url}" alt="${archivo.name}" class="w-full h-28 object-cover group-hover:scale-105 transition duration-200">
                        <button type="button" data-index="${index}" class="btn-eliminar-foto absolute top-2 right-2 w-7 h-7 bg-red-600 hover:bg-red-700 text-white rounded-full flex items-center justify-center shadow-lg transition transform hover:scale-110 cursor-pointer" title="Quitar foto">
                            <svg class="w-4 h-4 pointer-events-none" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                        </button>
                    </div>
                    <div class="p-2 text-xs">
                        <p class="truncate font-medium text-gray-700" title="${archivo.name}">${archivo.name}</p>
                        <p class="text-gray-400 text-[10px] mt-0.5">${pesoTexto}</p>
                    </div>
                `;

                card.querySelector('.btn-eliminar-foto').addEventListener('click', (e) => {
                    e.stopPropagation();
                    const i = parseInt(e.currentTarget.getAttribute('data-index'));
                    eliminarFoto(i);
                });

                vistaPrevia.appendChild(card);
            });
        }

        function eliminarFoto(indice) {
            const nuevaDt = new DataTransfer();
            Array.from(dt.files).forEach((f, i) => {
                if (i !== indice) nuevaDt.items.add(f);
            });
            dt = nuevaDt;
            inputImagenes.files = dt.files;
            renderizarVistaPrevia();
        }
    })();
</script>

@endsection