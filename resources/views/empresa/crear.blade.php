@extends('layouts.empresa')

@section('title', 'Nuevo inmueble')

@push('styles')
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" crossorigin=""/>
<style>
    .leaflet-container { font-family: inherit; }
</style>
@endpush

@section('content')

@php
    $input = 'w-full bg-neutral-950 border border-neutral-800 rounded-lg px-3.5 py-2.5 text-sm text-neutral-100 placeholder-neutral-500 focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition';
    $label = 'block mb-1.5 text-sm font-semibold text-neutral-300';
@endphp

<div class="max-w-4xl mx-auto pb-12">

    {{-- Encabezado --}}
    <div class="mb-6 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
        <div>
            <a href="{{ route('empresa.index') }}" class="inline-flex items-center gap-1.5 text-xs font-bold text-blue-400 hover:text-blue-300 transition mb-1">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
                <span>Volver a mis inmuebles</span>
            </a>
            <h1 class="text-2xl sm:text-3xl font-black text-white tracking-tight">Nuevo inmueble</h1>
            <p class="text-sm text-neutral-400 mt-0.5">Completa los datos del inmueble, su detalle y sus imágenes.</p>
        </div>
    </div>

    {{-- Errores de validación --}}
    @if ($errors->any())
        <div class="bg-rose-950/70 border border-rose-800/80 text-rose-200 p-5 rounded-2xl mb-6 text-sm shadow-xl">
            <div class="flex items-center gap-2 font-bold mb-1">
                <svg class="w-5 h-5 text-rose-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
                <span>Revisa estos campos:</span>
            </div>
            <ul class="list-disc list-inside text-xs space-y-0.5 ml-1">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('empresa.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
        @csrf
        <input type="hidden" name="id_usuario" value="{{ auth()->id() }}">

        {{-- 1. DATOS DEL INMUEBLE --}}
        <section class="bg-neutral-900/90 border border-neutral-800 rounded-2xl shadow-xl p-5 sm:p-6 backdrop-blur-md">
            <h3 class="text-lg font-bold text-white mb-4 pb-2 border-b border-neutral-800">Datos del inmueble</h3>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                {{-- 1. Nombre --}}
                <div class="md:col-span-2">
                    <label class="{{ $label }}">Nombre del inmueble <span class="text-rose-400">*</span></label>
                    <input type="text" name="nombre" value="{{ old('nombre') }}" placeholder="Ej: Hermosa casa campestre con vista panorámica" required class="{{ $input }}">
                </div>

                {{-- 2. Zona --}}
                <div>
                    <label class="{{ $label }}">Zona <span class="text-rose-400">*</span></label>
                    <select name="zona" id="zona" required class="{{ $input }}">
                        <option value="rural" class="bg-neutral-900" @selected(old('zona') === 'rural')>Rural</option>
                        <option value="urbana" class="bg-neutral-900" @selected(old('zona', 'urbana') === 'urbana')>Urbana</option>
                    </select>
                </div>

                {{-- 3. Usuario / Empresa (Fijo para esta empresa) --}}
                <div>
                    <label class="{{ $label }}">Usuario / Empresa</label>
                    <input type="text" value="{{ auth()->user()->nombre ?? auth()->user()->name }}" disabled class="{{ $input }} opacity-70 cursor-not-allowed">
                </div>

                {{-- 4. Tipo de inmueble --}}
                <div>
                    <label class="{{ $label }}">Tipo de inmueble <span class="text-rose-400">*</span></label>
                    <select name="id_tipo_inmueble" id="id_tipo_inmueble" required class="{{ $input }}">
                        <option value="" class="bg-neutral-900">Selecciona tipo</option>
                        @foreach ($tipo_inmueble as $tipo)
                            <option value="{{ $tipo->id }}" class="bg-neutral-900" @selected(old('id_tipo_inmueble') == $tipo->id)>{{ $tipo->nombre }}</option>
                        @endforeach
                    </select>
                </div>

                {{-- 5. Municipio --}}
                <div>
                    <label class="{{ $label }}">Municipio <span class="text-rose-400">*</span></label>
                    <select name="id_municipio" id="id_municipio" required class="{{ $input }}">
                        <option value="" class="bg-neutral-900">Selecciona municipio</option>
                        @foreach ($municipios as $m)
                            <option value="{{ $m->id }}" class="bg-neutral-900" @selected(old('id_municipio') == $m->id)>{{ $m->nombre }}</option>
                        @endforeach
                    </select>
                </div>

                {{-- 6. Barrio --}}
                <div>
                    <label class="{{ $label }}">Barrio <span class="text-xs text-neutral-400 font-normal">(Opcional)</span></label>
                    <select name="id_barrio" id="id_barrio" class="{{ $input }}">
                        <option value="" class="bg-neutral-900">Sin barrio / Zona rural</option>
                        @foreach ($barrios as $b)
                            <option value="{{ $b->id }}" class="bg-neutral-900" data-municipio="{{ $b->id_municipio }}" @selected(old('id_barrio') == $b->id)>
                                {{ $b->nombre }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>
        </section>

        {{-- 2. DETALLE DEL INMUEBLE --}}
        <section class="bg-neutral-900/90 border border-neutral-800 rounded-2xl shadow-xl p-5 sm:p-6 backdrop-blur-md">
            <h3 class="text-lg font-bold text-white mb-4 pb-2 border-b border-neutral-800">Detalle del inmueble</h3>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                {{-- 1. Dirección --}}
                <div class="md:col-span-2">
                    <label class="{{ $label }}">Dirección <span class="text-rose-400">*</span></label>
                    <input type="text" name="detalle[direccion]" value="{{ old('detalle.direccion') }}" placeholder="Ej: Carrera 7 # 12-45" required class="{{ $input }}">
                </div>

                {{-- Ubicación en Mapa --}}
                <div class="md:col-span-2">
                    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-2 mb-2">
                        <div>
                            <label class="{{ $label }} mb-0 flex items-center gap-1.5">
                                <svg class="w-4 h-4 text-red-500" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2C8.13 2 5 5.13 5 9c0 5.25 7 13 7 13s7-7.75 7-13c0-3.87-3.13-7-7-7zm0 9.5c-1.38 0-2.5-1.12-2.5-2.5s1.12-2.5 2.5-2.5 2.5 1.12 2.5 2.5-1.12 2.5-2.5 2.5z"/></svg>
                                <span>Fijar ubicación exacta en el mapa</span>
                            </label>
                            <p class="text-xs text-neutral-400">Haz clic en el mapa o arrastra el marcador rojo al punto exacto de la propiedad.</p>
                        </div>
                        <button type="button" id="btn-mi-ubicacion" class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-xl text-xs font-semibold bg-neutral-900 text-blue-400 hover:text-white hover:bg-neutral-800 border border-neutral-800 transition cursor-pointer self-start sm:self-auto">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><circle cx="12" cy="12" r="3" stroke-width="2"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 2v3m0 14v3M2 12h3m14 0h3"/></svg>
                            <span>📍 Mi ubicación actual</span>
                        </button>
                    </div>

                    <div id="mapa-selector" class="w-full h-72 rounded-2xl border border-neutral-800 overflow-hidden shadow-xl relative z-0"></div>

                    <div class="grid grid-cols-2 gap-3 mt-2.5">
                        <div>
                            <label class="block text-[11px] font-semibold uppercase tracking-wider text-neutral-400 mb-1">Latitud</label>
                            <input type="text" name="detalle[latitud]" id="input-latitud" value="{{ old('detalle.latitud') }}" readonly placeholder="Click en el mapa" class="{{ $input }} text-xs opacity-75 cursor-not-allowed">
                        </div>
                        <div>
                            <label class="block text-[11px] font-semibold uppercase tracking-wider text-neutral-400 mb-1">Longitud</label>
                            <input type="text" name="detalle[longitud]" id="input-longitud" value="{{ old('detalle.longitud') }}" readonly placeholder="Click en el mapa" class="{{ $input }} text-xs opacity-75 cursor-not-allowed">
                        </div>
                    </div>
                    <p id="badge-ubicacion" class="text-xs font-semibold text-emerald-400 mt-1.5 flex items-center gap-1 min-h-[18px]"></p>
                </div>

                {{-- 2. Tipo de oferta --}}
                <div>
                    <label class="{{ $label }}">Tipo de oferta <span class="text-rose-400">*</span></label>
                    <select name="detalle[tipo_oferta]" required class="{{ $input }}">
                        @foreach (['venta', 'arriendo', 'venta y arriendo'] as $oferta)
                            <option value="{{ $oferta }}" class="bg-neutral-900" @selected(old('detalle.tipo_oferta') === $oferta)>{{ ucfirst($oferta) }}</option>
                        @endforeach
                    </select>
                </div>

                {{-- 3. Estado de publicación --}}
                <div>
                    <label class="{{ $label }}">Estado de publicación <span class="text-rose-400">*</span></label>
                    <select name="detalle[estado_publicacion]" required class="{{ $input }}">
                        @foreach (['disponible', 'arrendado', 'vendido', 'reservado', 'inactivo'] as $estado)
                            <option value="{{ $estado }}" class="bg-neutral-900" @selected(old('detalle.estado_publicacion', 'disponible') === $estado)>{{ ucfirst($estado) }}</option>
                        @endforeach
                    </select>
                </div>

                {{-- 4. Precio --}}
                <div>
                    <label class="{{ $label }}">Precio <span class="text-rose-400">*</span></label>
                    <input type="number" step="0.01" name="detalle[precio]" value="{{ old('detalle.precio') }}" placeholder="Ej: 150000000" min="0" required class="{{ $input }}">
                </div>

                {{-- 5. Precio de administración --}}
                <div>
                    <label class="{{ $label }}">Precio de administración</label>
                    <input type="number" step="0.01" name="detalle[precio_administrador]" value="{{ old('detalle.precio_administrador', 0) }}" placeholder="0 si no aplica" min="0" class="{{ $input }}">
                </div>

                {{-- 6. Área --}}
                <div>
                    <label class="{{ $label }}">Área (m²) <span class="text-rose-400">*</span></label>
                    <input type="number" step="0.01" name="detalle[area]" value="{{ old('detalle.area') }}" placeholder="Ej: 85" min="0" required class="{{ $input }}">
                </div>

                {{-- 7. Estrato --}}
                <div id="campo-estrato">
                    <label class="{{ $label }}">Estrato</label>
                    <select name="detalle[estrato]" class="{{ $input }}">
                        <option value="" class="bg-neutral-900">Selecciona estrato</option>
                        @for ($i = 1; $i <= 6; $i++)
                            <option value="{{ $i }}" class="bg-neutral-900" {{ old('detalle.estrato') == $i ? 'selected' : '' }}>Estrato {{ $i }}</option>
                        @endfor
                    </select>
                </div>

                {{-- 8. Mascotas permitidas --}}
                <div id="campo-mascotas">
                    <label class="{{ $label }}">¿Admite mascotas? 🐾</label>
                    <select name="detalle[mascotas_permitidas]" class="{{ $input }}">
                        <option value="" class="bg-neutral-900">Sin especificar</option>
                        <option value="1" class="bg-neutral-900" {{ old('detalle.mascotas_permitidas') === '1' ? 'selected' : '' }}>Sí admite mascotas</option>
                        <option value="0" class="bg-neutral-900" {{ old('detalle.mascotas_permitidas') === '0' ? 'selected' : '' }}>No admite mascotas</option>
                    </select>
                </div>

                {{-- 9. Antigüedad --}}
                <div id="campo-antiguedad">
                    <label class="{{ $label }}">Antigüedad</label>
                    <select name="detalle[antiguedad]" class="{{ $input }}">
                        <option value="" class="bg-neutral-900">Selecciona antigüedad</option>
                        <option value="Para estrenar" class="bg-neutral-900" {{ old('detalle.antiguedad') == 'Para estrenar' ? 'selected' : '' }}>Para estrenar</option>
                        <option value="1 a 5 años" class="bg-neutral-900" {{ old('detalle.antiguedad') == '1 a 5 años' ? 'selected' : '' }}>1 a 5 años</option>
                        <option value="5 a 10 años" class="bg-neutral-900" {{ old('detalle.antiguedad') == '5 a 10 años' ? 'selected' : '' }}>5 a 10 años</option>
                        <option value="Más de 10 años" class="bg-neutral-900" {{ old('detalle.antiguedad') == 'Más de 10 años' ? 'selected' : '' }}>Más de 10 años</option>
                    </select>
                </div>

                {{-- 10. Fecha de publicación --}}
                <div>
                    <label class="{{ $label }}">Fecha de publicación</label>
                    <input type="date" name="detalle[fecha_publicacion]" value="{{ old('detalle.fecha_publicacion', date('Y-m-d')) }}" class="{{ $input }}">
                </div>

                {{-- 11. Habitaciones --}}
                <div id="campo-habitaciones">
                    <label class="{{ $label }}">Habitaciones</label>
                    <input type="number" name="detalle[numero_habitacion]" value="{{ old('detalle.numero_habitacion') }}" min="0" class="{{ $input }}">
                </div>

                {{-- 12. Baños --}}
                <div id="campo-banos">
                    <label class="{{ $label }}">Baños</label>
                    <input type="number" name="detalle[numero_bano]" value="{{ old('detalle.numero_bano') }}" min="0" class="{{ $input }}">
                </div>

                {{-- 13. Parqueaderos --}}
                <div id="campo-parqueaderos">
                    <label class="{{ $label }}">Parqueaderos</label>
                    <input type="number" name="detalle[numero_parqueadero]" value="{{ old('detalle.numero_parqueadero') }}" min="0" class="{{ $input }}">
                </div>

                {{-- 14. Piso --}}
                <div id="campo-piso">
                    <label class="{{ $label }}">Piso</label>
                    <input type="number" name="detalle[numero_piso]" value="{{ old('detalle.numero_piso') }}" min="0" class="{{ $input }}">
                </div>

                {{-- 15. Apartamento --}}
                <div id="campo-apartamento">
                    <label class="{{ $label }}">Apartamento</label>
                    <input type="number" name="detalle[numero_apartamento]" value="{{ old('detalle.numero_apartamento') }}" min="0" class="{{ $input }}">
                </div>

                {{-- 16. Descripción --}}
                <div class="md:col-span-2">
                    <label class="{{ $label }}">Descripción <span class="text-rose-400">*</span></label>
                    <textarea name="detalle[descripcion]" rows="4" placeholder="Describe los mejores atributos, iluminación, acabados, cercanías a parques, colegios o vías principales..." required class="{{ $input }}">{{ old('detalle.descripcion') }}</textarea>
                </div>
            </div>
        </section>

        {{-- 3. IMÁGENES --}}
        <section class="bg-neutral-900/90 border border-neutral-800 rounded-2xl shadow-xl p-5 sm:p-6 backdrop-blur-md">
            <div class="flex items-center justify-between mb-4 pb-2 border-b border-neutral-800">
                <div>
                    <h3 class="text-lg font-bold text-white">Galería de Imágenes</h3>
                    <p class="text-xs text-neutral-400">Sube hasta 10 fotos (máx. 5 MB c/u en formato JPG, PNG o WEBP).</p>
                </div>
                <span id="contador-fotos" class="hidden text-xs font-semibold px-2.5 py-1 bg-blue-950/80 text-blue-300 rounded-full border border-blue-800/80">
                    0 / 10 fotos
                </span>
            </div>

            {{-- Zona de Arrastrar y Soltar (Dropzone) --}}
            <div id="dropzone"
                 class="relative border-2 border-dashed border-neutral-800 hover:border-blue-500 rounded-xl p-8 text-center bg-neutral-950/70 hover:bg-neutral-950 transition-all cursor-pointer group">
                <input type="file"
                       name="imagenes[]"
                       id="imagenes"
                       multiple
                       accept="image/jpeg,image/png,image/webp,image/jpg"
                       class="absolute inset-0 w-full h-full opacity-0 cursor-pointer z-10">

                <div class="flex flex-col items-center justify-center space-y-2 pointer-events-none">
                    <div class="w-14 h-14 rounded-full bg-neutral-900 group-hover:bg-neutral-800 text-blue-400 flex items-center justify-center transition group-hover:scale-110 shadow-xs border border-neutral-800">
                        <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                        </svg>
                    </div>
                    <p class="text-sm font-semibold text-neutral-300 group-hover:text-blue-400 transition">
                        Arrastra y suelta tus fotos aquí, o <span class="text-blue-400 underline font-bold">haz clic para explorar</span>
                    </p>
                    <p class="text-xs text-neutral-500">
                        La primera foto seleccionada será la <strong class="text-blue-400">Foto de Portada</strong> en el catálogo público.
                    </p>
                </div>
            </div>

            {{-- Vista previa con opción de eliminar individualmente --}}
            <div id="vista-previa" class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 gap-4 mt-5 empty:hidden"></div>
        </section>

        {{-- Botones --}}
        <div class="flex items-center justify-end gap-3 pt-2">
            <a href="{{ route('empresa.index') }}"
               class="px-5 py-2.5 rounded-xl border border-neutral-800 text-neutral-400 hover:bg-neutral-900 hover:text-white font-medium transition">
                Cancelar
            </a>
            <button type="submit"
                    class="px-6 py-2.5 rounded-xl bg-blue-600 hover:bg-blue-500 text-white font-semibold shadow-xl shadow-blue-600/30 transition transform hover:-translate-y-0.5 cursor-pointer">
                Guardar
            </button>
        </div>
    </form>
</div>

<script>
    (function () {
        // Filtrar barrios dinámicamente según el municipio seleccionado
        const selectMunicipio = document.getElementById('id_municipio');
        const selectBarrio = document.getElementById('id_barrio');
        if (selectMunicipio && selectBarrio) {
            function filtrarBarrios() {
                const munId = selectMunicipio.value;
                const opciones = selectBarrio.querySelectorAll('option');
                let encontrado = false;

                opciones.forEach(opt => {
                    const munOpt = opt.getAttribute('data-municipio');
                    if (!munOpt) {
                        opt.style.display = '';
                    } else if (!munId || munOpt === munId) {
                        opt.style.display = '';
                        if (opt.selected) encontrado = true;
                    } else {
                        opt.style.display = 'none';
                        if (opt.selected) opt.selected = false;
                    }
                });
            }

            selectMunicipio.addEventListener('change', filtrarBarrios);
            filtrarBarrios();
        }

        const inputImagenes = document.getElementById('imagenes');
        const dropzone = document.getElementById('dropzone');
        const vistaPrevia = document.getElementById('vista-previa');
        const contadorFotos = document.getElementById('contador-fotos');
        let dt = new DataTransfer();

        ['dragenter', 'dragover'].forEach(eName => {
            dropzone.addEventListener(eName, (e) => {
                e.preventDefault();
                e.stopPropagation();
                dropzone.classList.add('border-blue-500', 'bg-neutral-900');
            }, false);
        });

        ['dragleave', 'drop'].forEach(eName => {
            dropzone.addEventListener(eName, (e) => {
                e.preventDefault();
                e.stopPropagation();
                dropzone.classList.remove('border-blue-500', 'bg-neutral-900');
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

                const yaExiste = Array.from(dt.files).some(
                    f => f.name === archivo.name && f.size === archivo.size
                );

                if (!yaExiste) {
                    dt.items.add(archivo);
                }
            });

            inputImagenes.files = dt.files;
            renderizarVistaPrevia();
        }

        function renderizarVistaPrevia() {
            vistaPrevia.innerHTML = '';
            const total = dt.files.length;

            if (total > 0) {
                contadorFotos.classList.remove('hidden');
                contadorFotos.textContent = `${total} / 10 fotos`;
            } else {
                contadorFotos.classList.add('hidden');
            }

            Array.from(dt.files).forEach((archivo, index) => {
                const contenedor = document.createElement('div');
                contenedor.className = 'relative group rounded-xl overflow-hidden border border-neutral-800 bg-neutral-950 shadow-sm aspect-4/3 flex items-center justify-center';

                const url = URL.createObjectURL(archivo);
                const img = document.createElement('img');
                img.src = url;
                img.alt = archivo.name;
                img.className = 'w-full h-full object-cover';

                if (index === 0) {
                    const badgePortada = document.createElement('span');
                    badgePortada.className = 'absolute top-2 left-2 bg-amber-500 text-white text-[10px] font-bold px-2 py-0.5 rounded shadow-sm z-10 flex items-center gap-1';
                    badgePortada.innerHTML = '⭐ Portada';
                    contenedor.appendChild(badgePortada);
                }

                const btnEliminar = document.createElement('button');
                btnEliminar.type = 'button';
                btnEliminar.className = 'absolute top-2 right-2 bg-rose-600 hover:bg-rose-700 text-white w-6 h-6 rounded-full flex items-center justify-center text-xs shadow-md transition transform hover:scale-110 z-10 cursor-pointer';
                btnEliminar.innerHTML = '✕';
                btnEliminar.title = 'Quitar foto';
                btnEliminar.addEventListener('click', (e) => {
                    e.stopPropagation();
                    removerArchivo(index);
                });

                const pie = document.createElement('div');
                pie.className = 'absolute inset-x-0 bottom-0 bg-gradient-to-t from-black/80 to-transparent p-2 text-[10px] text-neutral-300 truncate';
                pie.textContent = archivo.name;

                contenedor.appendChild(img);
                contenedor.appendChild(btnEliminar);
                contenedor.appendChild(pie);
                vistaPrevia.appendChild(contenedor);
            });
        }

        function removerArchivo(indice) {
            const nuevoDt = new DataTransfer();
            Array.from(dt.files).forEach((archivo, i) => {
                if (i !== indice) {
                    nuevoDt.items.add(archivo);
                }
            });
            dt = nuevoDt;
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
    });
</script>
@endpush

@endsection
