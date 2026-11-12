@extends('layouts.app')

@section('title')
    Editar inmueble
@endsection

@push('styles')
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" crossorigin=""/>
<style>
    .leaflet-container { font-family: inherit; }
</style>
@endpush

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
                        <select name="id_tipo_inmueble" id="id_tipo_inmueble" class="{{ $input }}">
                            @foreach ($tipo_inmueble as $tipo)
                                <option value="{{ $tipo->id }}" @selected(old('id_tipo_inmueble', $inmueble->id_tipo_inmueble) == $tipo->id)>{{ $tipo->nombre }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label class="{{ $label }}">Municipio</label>
                        <select name="id_municipio" id="id_municipio" class="{{ $input }}">
                            <option value="">Selecciona municipio</option>
                            @foreach ($municipios as $municipio)
                                <option value="{{ $municipio->id }}" @selected(old('id_municipio', $inmueble->id_municipio) == $municipio->id)>{{ $municipio->nombre }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label id="label-barrio" class="{{ $label }}">Barrio / Vereda <span class="text-xs text-gray-400 font-normal">(Opcional)</span></label>
                        <select name="id_barrio" id="id_barrio" class="{{ $input }}">
                            <option value="" id="opcion-defecto-barrio">Sin especificar / Casco urbano</option>
                            @foreach ($barrios as $b)
                                @php
                                    $esVda = str_contains(strtolower($b->nombre), 'vda') || str_contains(strtolower($b->nombre), 'vereda');
                                @endphp
                                <option value="{{ $b->id }}"
                                        data-municipio="{{ $b->id_municipio }}"
                                        data-tipo="{{ $esVda ? 'rural' : 'urbana' }}"
                                        @selected(old('id_barrio', $inmueble->id_barrio) == $b->id)>
                                    {{ $b->nombre }}
                                </option>
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

                    {{-- Ubicación en Mapa --}}
                    <div class="md:col-span-2">
                        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-2 mb-2">
                            <div>
                                <label class="{{ $label }} mb-0 flex items-center gap-1.5">
                                    <svg class="w-4 h-4 text-red-500" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2C8.13 2 5 5.13 5 9c0 5.25 7 13 7 13s7-7.75 7-13c0-3.87-3.13-7-7-7zm0 9.5c-1.38 0-2.5-1.12-2.5-2.5s1.12-2.5 2.5-2.5 2.5 1.12 2.5 2.5-1.12 2.5-2.5 2.5z"/></svg>
                                    <span>Fijar ubicación exacta en el mapa</span>
                                </label>
                                <p class="text-xs text-gray-500">Haz clic en el mapa o arrastra el marcador rojo al punto exacto del inmueble.</p>
                            </div>
                            <button type="button" id="btn-mi-ubicacion" class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg text-xs font-semibold bg-indigo-50 text-indigo-700 hover:bg-indigo-100 border border-indigo-200 transition cursor-pointer self-start sm:self-auto">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><circle cx="12" cy="12" r="3" stroke-width="2"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 2v3m0 14v3M2 12h3m14 0h3"/></svg>
                                <span>📍 Mi ubicación actual</span>
                            </button>
                        </div>

                        <div id="mapa-selector" class="w-full h-72 rounded-xl border border-gray-300 overflow-hidden shadow-xs relative z-0"></div>

                        <div class="grid grid-cols-2 gap-3 mt-2.5">
                            <div>
                                <label class="block text-[11px] font-semibold uppercase tracking-wider text-gray-500 mb-1">Latitud</label>
                                <input type="text" name="detalle[latitud]" id="input-latitud" value="{{ old('detalle.latitud', $d->latitud ?? '') }}" readonly placeholder="Click en el mapa" class="{{ $input }} text-xs bg-gray-50 text-gray-700 cursor-not-allowed">
                            </div>
                            <div>
                                <label class="block text-[11px] font-semibold uppercase tracking-wider text-gray-500 mb-1">Longitud</label>
                                <input type="text" name="detalle[longitud]" id="input-longitud" value="{{ old('detalle.longitud', $d->longitud ?? '') }}" readonly placeholder="Click en el mapa" class="{{ $input }} text-xs bg-gray-50 text-gray-700 cursor-not-allowed">
                            </div>
                        </div>
                        <p id="badge-ubicacion" class="text-xs font-semibold text-emerald-600 mt-1.5 flex items-center gap-1 min-h-[18px]"></p>
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
                        <label class="{{ $label }}">Precio <span class="text-red-500">*</span></label>
                        <input type="number" step="0.01" min="0" name="detalle[precio]" value="{{ old('detalle.precio', $d->precio ?? '') }}" class="{{ $input }}">
                        @error('detalle.precio')
                            <p class="text-xs text-red-600 mt-1 font-medium">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="{{ $label }}">Precio de administración</label>
                        <input type="number" step="0.01" min="0" name="detalle[precio_administrador]" value="{{ old('detalle.precio_administrador', $d->precio_administrador ?? 0) }}" class="{{ $input }}">
                        @error('detalle.precio_administrador')
                            <p class="text-xs text-red-600 mt-1 font-medium">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="{{ $label }}">Área (m²) <span class="text-red-500">*</span></label>
                        <input type="number" step="0.01" min="0" name="detalle[area]" value="{{ old('detalle.area', $d->area ?? '') }}" class="{{ $input }}">
                        @error('detalle.area')
                            <p class="text-xs text-red-600 mt-1 font-medium">{{ $message }}</p>
                        @enderror
                    </div>

                    <div id="campo-estrato">
                        <label class="{{ $label }}">Estrato</label>
                        <select name="detalle[estrato]" class="{{ $input }}">
                            <option value="">Selecciona estrato</option>
                            @for ($i = 1; $i <= 6; $i++)
                                <option value="{{ $i }}" {{ old('detalle.estrato', $d->estrato ?? '') == $i ? 'selected' : '' }}>Estrato {{ $i }}</option>
                            @endfor
                        </select>
                    </div>

                    <div id="campo-mascotas">
                        <label class="{{ $label }}">¿Admite mascotas? 🐾</label>
                        <select name="detalle[mascotas_permitidas]" class="{{ $input }}">
                            <option value="">Sin especificar</option>
                            <option value="1" {{ old('detalle.mascotas_permitidas', isset($d->mascotas_permitidas) ? (string)(int)$d->mascotas_permitidas : '') === '1' ? 'selected' : '' }}>Sí admite mascotas</option>
                            <option value="0" {{ old('detalle.mascotas_permitidas', isset($d->mascotas_permitidas) ? (string)(int)$d->mascotas_permitidas : '') === '0' ? 'selected' : '' }}>No admite mascotas</option>
                        </select>
                    </div>

                    <div id="campo-antiguedad">
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

                    <div id="campo-habitaciones">
                        <label class="{{ $label }}">Habitaciones</label>
                        <input type="number" name="detalle[numero_habitacion]" value="{{ old('detalle.numero_habitacion', $d->numero_habitacion ?? '') }}" class="{{ $input }}">
                    </div>

                    <div id="campo-banos">
                        <label class="{{ $label }}">Baños</label>
                        <input type="number" name="detalle[numero_bano]" value="{{ old('detalle.numero_bano', $d->numero_bano ?? '') }}" class="{{ $input }}">
                    </div>

                    <div id="campo-parqueaderos">
                        <label class="{{ $label }}">Parqueaderos</label>
                        <input type="number" name="detalle[numero_parqueadero]" value="{{ old('detalle.numero_parqueadero', $d->numero_parqueadero ?? '') }}" class="{{ $input }}">
                    </div>

                    <div id="campo-piso">
                        <label class="{{ $label }}">Piso</label>
                        <input type="number" name="detalle[numero_piso]" value="{{ old('detalle.numero_piso', $d->numero_piso ?? '') }}" class="{{ $input }}">
                    </div>

                    <div id="campo-apartamento">
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
        // Filtrar barrios y veredas dinámicamente según municipio y zona (urbana/rural)
        const selectMunicipio = document.getElementById('id_municipio');
        const selectZona = document.getElementById('zona');
        const selectBarrio = document.getElementById('id_barrio');
        const labelBarrio = document.getElementById('label-barrio');
        const opcionDefecto = document.getElementById('opcion-defecto-barrio');

        if (selectMunicipio && selectBarrio) {
            function filtrarSubdivisiones() {
                const munId = selectMunicipio.value;
                const zonaVal = selectZona ? selectZona.value : '';
                const opciones = selectBarrio.querySelectorAll('option');

                if (labelBarrio) {
                    labelBarrio.innerHTML = zonaVal === 'rural'
                        ? 'Vereda <span class="text-xs text-gray-400 font-normal">(Zona Rural)</span>'
                        : 'Barrio <span class="text-xs text-gray-400 font-normal">(Casco Urbano)</span>';
                }

                if (opcionDefecto) {
                    opcionDefecto.textContent = zonaVal === 'rural'
                        ? 'Selecciona vereda (Opcional)'
                        : 'Selecciona barrio (Opcional)';
                }

                let encontrado = false;

                opciones.forEach(opt => {
                    const munOpt = opt.getAttribute('data-municipio');
                    const tipoOpt = opt.getAttribute('data-tipo');

                    if (!munOpt) {
                        opt.style.display = '';
                        return;
                    }

                    const coincideMun = !munId || munOpt === munId;
                    const coincideZona = !zonaVal || tipoOpt === zonaVal;

                    if (coincideMun && coincideZona) {
                        opt.style.display = '';
                        if (opt.selected) encontrado = true;
                    } else {
                        opt.style.display = 'none';
                        if (opt.selected) opt.selected = false;
                    }
                });

                if (!encontrado && selectBarrio.value !== '') {
                    selectBarrio.value = '';
                }
            }

            selectMunicipio.addEventListener('change', filtrarSubdivisiones);
            if (selectZona) selectZona.addEventListener('change', filtrarSubdivisiones);
            filtrarSubdivisiones();
        }

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

@push('scripts')
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" crossorigin=""></script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const municipiosCoords = {
            'Capitanejo': [6.5292, -72.6964],
            'Carcasí': [6.6333, -72.6333],
            'Cepitá': [6.7444, -72.9819],
            'Cerrito': [6.8436, -72.6942],
            'Concepción': [6.7167, -72.6833],
            'Enciso': [6.6667, -72.7000],
            'Guaca': [6.8833, -72.8500],
            'Macaravita': [6.6389, -72.5833],
            'Málaga': [6.7023, -72.7314],
            'Molagavita': [6.6667, -72.7833],
            'San Andrés': [6.8111, -72.8489],
            'San José de Miranda': [6.6578, -72.7303],
            'San Miguel': [6.5778, -72.6472]
        };

        const inputLat = document.getElementById('input-latitud');
        const inputLng = document.getElementById('input-longitud');
        const selectMunicipio = document.getElementById('id_municipio');
        const btnUbicacion = document.getElementById('btn-mi-ubicacion');

        const initialLat = parseFloat(inputLat.value) || 6.7023;
        const initialLng = parseFloat(inputLng.value) || -72.7314;
        const hasInitial = !isNaN(parseFloat(inputLat.value)) && !isNaN(parseFloat(inputLng.value));

        // Capa Satélite Google de alta resolución
        const satelite = L.tileLayer('https://mt1.google.com/vt/lyrs=y&x={x}&y={y}&z={z}', {
            maxZoom: 20,
            attribution: '&copy; Google Maps'
        });

        // Capa Calles
        const calles = L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            maxZoom: 19,
            attribution: '&copy; OpenStreetMap contributors'
        });

        const map = L.map('mapa-selector', {
            center: [initialLat, initialLng],
            zoom: hasInitial ? 18 : 14,
            layers: [satelite]
        });

        // Selector de vista Satélite / Calles
        L.control.layers({
            "🛰️ Satélite (Casas)": satelite,
            "🗺️ Calles (Mapa)": calles
        }, null, { position: 'topright' }).addTo(map);

        let marker = null;
        const badgeUbicacion = document.getElementById('badge-ubicacion');

        const pinIcon = L.divIcon({
            className: 'custom-pin-marcador',
            html: `
                <div style="position: relative; width: 36px; height: 44px; filter: drop-shadow(0 4px 8px rgba(0,0,0,0.5));">
                    <svg viewBox="0 0 24 24" fill="none" style="width: 100%; height: 100%;">
                        <path d="M12 2C8.13 2 5 5.13 5 9c0 5.25 7 13 7 13s7-7.75 7-13c0-3.87-3.13-7-7-7z" fill="#EF4444" stroke="#FFFFFF" stroke-width="1.8"/>
                        <circle cx="12" cy="9" r="3.2" fill="#FFFFFF"/>
                    </svg>
                </div>
            `,
            iconSize: [36, 44],
            iconAnchor: [18, 44],
            popupAnchor: [0, -44]
        });

        function setCoordinates(lat, lng, zoom = null) {
            inputLat.value = lat.toFixed(7);
            inputLng.value = lng.toFixed(7);

            if (badgeUbicacion) {
                badgeUbicacion.innerHTML = `<span>✅ Marca fijada: <strong>${lat.toFixed(6)}, ${lng.toFixed(6)}</strong> (puedes arrastrar el pin si deseas moverlo)</span>`;
            }

            if (!marker) {
                marker = L.marker([lat, lng], { draggable: true, icon: pinIcon }).addTo(map);
                marker.on('dragend', function (e) {
                    const pos = e.target.getLatLng();
                    setCoordinates(pos.lat, pos.lng);
                });
            } else {
                marker.setLatLng([lat, lng]);
            }

            if (zoom) {
                map.flyTo([lat, lng], zoom);
            }
        }

        if (hasInitial) {
            setCoordinates(initialLat, initialLng);
            map.setView([initialLat, initialLng], 18);
        }

        map.on('click', function (e) {
            setCoordinates(e.latlng.lat, e.latlng.lng);
        });

        // Al cambiar de municipio, centrar el mapa
        if (selectMunicipio) {
            selectMunicipio.addEventListener('change', function () {
                const nombre = this.options[this.selectedIndex]?.text?.trim();
                if (nombre && municipiosCoords[nombre]) {
                    const coords = municipiosCoords[nombre];
                    map.flyTo(coords, 14);
                    if (!marker) {
                        setCoordinates(coords[0], coords[1]);
                    }
                }
            });
        }

        // Botón GPS: mi ubicación actual
        if (btnUbicacion && navigator.geolocation) {
            btnUbicacion.addEventListener('click', function () {
                btnUbicacion.classList.add('opacity-50');
                navigator.geolocation.getCurrentPosition(
                    function (pos) {
                        btnUbicacion.classList.remove('opacity-50');
                        setCoordinates(pos.coords.latitude, pos.coords.longitude, 16);
                    },
                    function (err) {
                        btnUbicacion.classList.remove('opacity-50');
                        alert('No se pudo obtener tu ubicación GPS. Asegúrate de permitir los permisos en tu navegador.');
                    },
                    { enableHighAccuracy: true, timeout: 10000 }
                );
            });
        }

        // ==========================================
        // ADAPTACIÓN DINÁMICA POR TIPO DE INMUEBLE
        // ==========================================
        const selectTipoInmueble = document.getElementById('id_tipo_inmueble');
        const campoEstrato = document.getElementById('campo-estrato');
        const campoMascotas = document.getElementById('campo-mascotas');
        const campoAntiguedad = document.getElementById('campo-antiguedad');
        const campoHabitaciones = document.getElementById('campo-habitaciones');
        const campoBanos = document.getElementById('campo-banos');
        const campoParqueaderos = document.getElementById('campo-parqueaderos');
        const campoPiso = document.getElementById('campo-piso');
        const campoApartamento = document.getElementById('campo-apartamento');

        function toggleCampo(el, visible, limpiar = false) {
            if (!el) return;
            if (visible) {
                el.classList.remove('hidden');
            } else {
                el.classList.add('hidden');
                if (limpiar) {
                    const input = el.querySelector('input, select');
                    if (input) input.value = '';
                }
            }
        }

        function adaptarCamposPorTipo(limpiar = false) {
            if (!selectTipoInmueble) return;
            const texto = (selectTipoInmueble.options[selectTipoInmueble.selectedIndex]?.text || '').toLowerCase().trim();

            const esLote = texto.includes('lote') || (texto.includes('terreno') && !texto.includes('campestre'));
            const esLocal = texto.includes('local') || texto.includes('comercial');
            const esFinca = texto.includes('finca') || texto.includes('campestre');
            const esCasa = texto.includes('casa');
            const esApto = texto.includes('apartamento') || texto.includes('apto');

            if (esLote) {
                // Lote / Terreno: Solo Área y Estrato
                toggleCampo(campoEstrato, true);
                toggleCampo(campoMascotas, false, limpiar);
                toggleCampo(campoAntiguedad, false, limpiar);
                toggleCampo(campoHabitaciones, false, limpiar);
                toggleCampo(campoBanos, false, limpiar);
                toggleCampo(campoParqueaderos, false, limpiar);
                toggleCampo(campoPiso, false, limpiar);
                toggleCampo(campoApartamento, false, limpiar);
            } else if (esLocal) {
                // Local Comercial: Área, Baños, Parqueaderos, Estrato, Antigüedad y Piso
                toggleCampo(campoEstrato, true);
                toggleCampo(campoMascotas, false, limpiar);
                toggleCampo(campoAntiguedad, true);
                toggleCampo(campoHabitaciones, false, limpiar);
                toggleCampo(campoBanos, true);
                toggleCampo(campoParqueaderos, true);
                toggleCampo(campoPiso, true);
                toggleCampo(campoApartamento, false, limpiar);
            } else if (esFinca) {
                // Finca / Campestre: Área, Habitaciones, Baños, Parqueaderos, Mascotas, Antigüedad, Estrato
                toggleCampo(campoEstrato, true);
                toggleCampo(campoMascotas, true);
                toggleCampo(campoAntiguedad, true);
                toggleCampo(campoHabitaciones, true);
                toggleCampo(campoBanos, true);
                toggleCampo(campoParqueaderos, true);
                toggleCampo(campoPiso, false, limpiar);
                toggleCampo(campoApartamento, false, limpiar);
            } else if (esCasa) {
                // Casa: Todo lo residencial excepto Apartamento
                toggleCampo(campoEstrato, true);
                toggleCampo(campoMascotas, true);
                toggleCampo(campoAntiguedad, true);
                toggleCampo(campoHabitaciones, true);
                toggleCampo(campoBanos, true);
                toggleCampo(campoParqueaderos, true);
                toggleCampo(campoPiso, true);
                toggleCampo(campoApartamento, false, limpiar);
            } else {
                // Apartamento o por defecto: Muestra todo
                toggleCampo(campoEstrato, true);
                toggleCampo(campoMascotas, true);
                toggleCampo(campoAntiguedad, true);
                toggleCampo(campoHabitaciones, true);
                toggleCampo(campoBanos, true);
                toggleCampo(campoParqueaderos, true);
                toggleCampo(campoPiso, true);
                toggleCampo(campoApartamento, true);
            }
        }

        if (selectTipoInmueble) {
            selectTipoInmueble.addEventListener('change', () => adaptarCamposPorTipo(true));
            adaptarCamposPorTipo(false);
        }

        // ==========================================
        // Validación en tiempo real contra precios negativos
        // ==========================================
        const camposNoNegativos = document.querySelectorAll(
            'input[name="detalle[precio]"], input[name="detalle[precio_administrador]"], input[name="detalle[area]"]'
        );

        camposNoNegativos.forEach(input => {
            let alertBox = input.parentElement.querySelector('.alerta-negativo-dinamica');
            if (!alertBox) {
                alertBox = document.createElement('div');
                alertBox.className = 'alerta-negativo-dinamica hidden mt-1.5 text-xs font-semibold px-2.5 py-1.5 rounded-lg border border-red-300 bg-red-50 text-red-700 flex items-center gap-1.5 shadow-sm transition-all duration-200';
                input.parentElement.appendChild(alertBox);
            }

            const mostrarAlertaNegativo = (mensaje) => {
                alertBox.innerHTML = `
                    <svg class="w-4 h-4 shrink-0 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                    </svg>
                    <span>${mensaje}</span>
                `;
                alertBox.classList.remove('hidden');
                input.classList.add('border-red-500', 'ring-2', 'ring-red-300', 'bg-red-50/50');

                clearTimeout(input._negativoTimeout);
                input._negativoTimeout = setTimeout(() => {
                    if (!input.value.includes('-') && (parseFloat(input.value) >= 0 || !input.value)) {
                        ocultarAlertaNegativo();
                    }
                }, 3500);
            };

            const ocultarAlertaNegativo = () => {
                alertBox.classList.add('hidden');
                input.classList.remove('border-red-500', 'ring-2', 'ring-red-300', 'bg-red-50/50');
            };

            // Detectar al presionar la tecla del signo menos (-)
            input.addEventListener('keydown', function (e) {
                if (e.key === '-' || e.key === 'Subtract' || e.keyCode === 189 || e.keyCode === 109) {
                    e.preventDefault();
                    mostrarAlertaNegativo('¡No se permiten valores negativos! El signo menos (-) no es válido.');
                }
            });

            // Detectar al pegar o modificar el valor
            input.addEventListener('input', function () {
                if (this.value.includes('-') || parseFloat(this.value) < 0) {
                    this.value = this.value.replace(/-/g, '');
                    mostrarAlertaNegativo('¡Valor negativo no permitido! Solo números mayores o iguales a 0.');
                } else {
                    ocultarAlertaNegativo();
                }
            });
        });

        // Asegurar que Leaflet calcule el tamaño exacto del mapa
        setTimeout(() => {
            if (typeof map !== 'undefined' && map) {
                map.invalidateSize();
            }
        }, 300);
    });
</script>
@endpush

@endsection