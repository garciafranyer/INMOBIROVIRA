@extends('layouts.empresa')

@section('title', 'Editar inmueble')

@section('content')

@php
    $input = 'w-full bg-neutral-950 border border-neutral-800 rounded-lg px-3.5 py-2.5 text-sm text-neutral-100 placeholder-neutral-500 focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition';
    $label = 'block mb-1.5 text-sm font-semibold text-neutral-300';
    $d = $inmueble->detalle_inmueble;
@endphp

<div class="max-w-4xl mx-auto pb-12">

    {{-- Encabezado con enlace público --}}
    <div class="mb-6 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
        <div>
            <a href="{{ route('empresa.index') }}" class="inline-flex items-center gap-1.5 text-xs font-bold text-blue-400 hover:text-blue-300 transition mb-1">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
                <span>Volver a mis inmuebles</span>
            </a>
            <h1 class="text-2xl sm:text-3xl font-black text-white tracking-tight">Editar inmueble</h1>
            <p class="text-sm text-neutral-400 mt-0.5">Modifica los datos del inmueble, su detalle y sus imágenes.</p>
        </div>

        <a href="{{ route('propiedad.show', $inmueble->id) }}" target="_blank"
           class="inline-flex items-center gap-2 px-4 py-2.5 rounded-xl border border-neutral-800 bg-neutral-900/90 text-xs font-bold text-neutral-300 hover:text-white hover:bg-neutral-800 transition shadow-lg self-start sm:self-auto">
            <span>Ver ficha en la web</span>
            <svg class="w-3.5 h-3.5 text-neutral-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/></svg>
        </a>
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

    <form action="{{ route('empresa.update', $inmueble->id) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
        @csrf
        @method('PUT')
        <input type="hidden" name="id_usuario" value="{{ auth()->id() }}">

        {{-- 1. DATOS DEL INMUEBLE --}}
        <section class="bg-neutral-900/90 border border-neutral-800 rounded-2xl shadow-xl p-5 sm:p-6 backdrop-blur-md">
            <h3 class="text-lg font-bold text-white mb-4 pb-2 border-b border-neutral-800">Datos del inmueble</h3>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                {{-- 1. Nombre --}}
                <div class="md:col-span-2">
                    <label class="{{ $label }}">Nombre del inmueble <span class="text-rose-400">*</span></label>
                    <input type="text" name="nombre" value="{{ old('nombre', $inmueble->nombre) }}" required class="{{ $input }}">
                </div>

                {{-- 2. Zona --}}
                <div>
                    <label class="{{ $label }}">Zona <span class="text-rose-400">*</span></label>
                    <select name="zona" id="zona" required class="{{ $input }}">
                        <option value="rural" class="bg-neutral-900" @selected(old('zona', $inmueble->zona) === 'rural')>Rural</option>
                        <option value="urbana" class="bg-neutral-900" @selected(old('zona', $inmueble->zona) === 'urbana')>Urbana</option>
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
                    <select name="id_tipo_inmueble" required class="{{ $input }}">
                        @foreach ($tipo_inmueble as $tipo)
                            <option value="{{ $tipo->id }}" class="bg-neutral-900" @selected(old('id_tipo_inmueble', $inmueble->id_tipo_inmueble) == $tipo->id)>
                                {{ $tipo->nombre }}
                            </option>
                        @endforeach
                    </select>
                </div>

                {{-- 5. Municipio --}}
                <div>
                    <label class="{{ $label }}">Municipio <span class="text-rose-400">*</span></label>
                    <select name="id_municipio" id="id_municipio" required class="{{ $input }}">
                        @foreach ($municipios as $m)
                            <option value="{{ $m->id }}" class="bg-neutral-900" @selected(old('id_municipio', $inmueble->id_municipio) == $m->id)>
                                {{ $m->nombre }}
                            </option>
                        @endforeach
                    </select>
                </div>

                {{-- 6. Barrio --}}
                <div>
                    <label class="{{ $label }}">Barrio <span class="text-xs text-neutral-400 font-normal">(Opcional)</span></label>
                    <select name="id_barrio" id="id_barrio" class="{{ $input }}">
                        <option value="" class="bg-neutral-900">Sin barrio / Zona rural</option>
                        @foreach ($barrios as $b)
                            <option value="{{ $b->id }}" class="bg-neutral-900" data-municipio="{{ $b->id_municipio }}" @selected(old('id_barrio', $inmueble->id_barrio) == $b->id)>
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

            @unless ($d)
                <p class="mb-4 text-sm text-amber-300 bg-amber-950/60 border border-amber-800/80 rounded-xl px-4 py-2.5">
                    Este inmueble aún no tiene detalle. Al guardar se creará con los datos de abajo.
                </p>
            @endunless

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                {{-- 1. Dirección --}}
                <div class="md:col-span-2">
                    <label class="{{ $label }}">Dirección <span class="text-rose-400">*</span></label>
                    <input type="text" name="detalle[direccion]" value="{{ old('detalle.direccion', $d?->direccion ?? '') }}" required class="{{ $input }}">
                </div>

                {{-- 2. Tipo de oferta --}}
                <div>
                    <label class="{{ $label }}">Tipo de oferta <span class="text-rose-400">*</span></label>
                    <select name="detalle[tipo_oferta]" required class="{{ $input }}">
                        @foreach (['venta', 'arriendo', 'venta y arriendo'] as $oferta)
                            <option value="{{ $oferta }}" class="bg-neutral-900" @selected(old('detalle.tipo_oferta', $d?->tipo_oferta ?? '') === $oferta)>{{ ucfirst($oferta) }}</option>
                        @endforeach
                    </select>
                </div>

                {{-- 3. Estado de publicación --}}
                <div>
                    <label class="{{ $label }}">Estado de publicación <span class="text-rose-400">*</span></label>
                    <select name="detalle[estado_publicacion]" required class="{{ $input }}">
                        @foreach (['disponible', 'arrendado', 'vendido', 'reservado', 'inactivo'] as $estado)
                            <option value="{{ $estado }}" class="bg-neutral-900" @selected(old('detalle.estado_publicacion', $d?->estado_publicacion ?? 'disponible') === $estado)>{{ ucfirst($estado) }}</option>
                        @endforeach
                    </select>
                </div>

                {{-- 4. Precio --}}
                <div>
                    <label class="{{ $label }}">Precio <span class="text-rose-400">*</span></label>
                    <input type="number" step="0.01" name="detalle[precio]" value="{{ old('detalle.precio', $d?->precio ?? '') }}" min="0" required class="{{ $input }}">
                </div>

                {{-- 5. Precio de administración --}}
                <div>
                    <label class="{{ $label }}">Precio de administración</label>
                    <input type="number" step="0.01" name="detalle[precio_administrador]" value="{{ old('detalle.precio_administrador', $d?->precio_administrador ?? 0) }}" min="0" class="{{ $input }}">
                </div>

                {{-- 6. Área --}}
                <div>
                    <label class="{{ $label }}">Área (m²) <span class="text-rose-400">*</span></label>
                    <input type="number" step="0.01" name="detalle[area]" value="{{ old('detalle.area', $d?->area ?? '') }}" min="0" required class="{{ $input }}">
                </div>

                {{-- 7. Estrato --}}
                <div>
                    <label class="{{ $label }}">Estrato</label>
                    <select name="detalle[estrato]" class="{{ $input }}">
                        <option value="" class="bg-neutral-900">Selecciona estrato</option>
                        @for ($i = 1; $i <= 6; $i++)
                            <option value="{{ $i }}" class="bg-neutral-900" {{ old('detalle.estrato', $d?->estrato ?? '') == $i ? 'selected' : '' }}>Estrato {{ $i }}</option>
                        @endfor
                    </select>
                </div>

                {{-- 8. Mascotas permitidas --}}
                <div>
                    <label class="{{ $label }}">¿Admite mascotas? 🐾</label>
                    <select name="detalle[mascotas_permitidas]" class="{{ $input }}">
                        <option value="" class="bg-neutral-900">Sin especificar</option>
                        <option value="1" class="bg-neutral-900" {{ old('detalle.mascotas_permitidas', (string)($d?->mascotas_permitidas ?? '')) === '1' ? 'selected' : '' }}>Sí admite mascotas</option>
                        <option value="0" class="bg-neutral-900" {{ old('detalle.mascotas_permitidas', (string)($d?->mascotas_permitidas ?? '')) === '0' ? 'selected' : '' }}>No admite mascotas</option>
                    </select>
                </div>

                {{-- 9. Antigüedad --}}
                <div>
                    <label class="{{ $label }}">Antigüedad</label>
                    <select name="detalle[antiguedad]" class="{{ $input }}">
                        <option value="" class="bg-neutral-900">Selecciona antigüedad</option>
                        <option value="Para estrenar" class="bg-neutral-900" {{ old('detalle.antiguedad', $d?->antiguedad ?? '') == 'Para estrenar' ? 'selected' : '' }}>Para estrenar</option>
                        <option value="1 a 5 años" class="bg-neutral-900" {{ old('detalle.antiguedad', $d?->antiguedad ?? '') == '1 a 5 años' ? 'selected' : '' }}>1 a 5 años</option>
                        <option value="5 a 10 años" class="bg-neutral-900" {{ old('detalle.antiguedad', $d?->antiguedad ?? '') == '5 a 10 años' ? 'selected' : '' }}>5 a 10 años</option>
                        <option value="Más de 10 años" class="bg-neutral-900" {{ old('detalle.antiguedad', $d?->antiguedad ?? '') == 'Más de 10 años' ? 'selected' : '' }}>Más de 10 años</option>
                    </select>
                </div>

                {{-- 10. Fecha de publicación --}}
                <div>
                    <label class="{{ $label }}">Fecha de publicación</label>
                    <input type="date" name="detalle[fecha_publicacion]" value="{{ old('detalle.fecha_publicacion', $d?->fecha_publicacion ?? date('Y-m-d')) }}" class="{{ $input }}">
                </div>

                {{-- 11. Habitaciones --}}
                <div>
                    <label class="{{ $label }}">Habitaciones</label>
                    <input type="number" name="detalle[numero_habitacion]" value="{{ old('detalle.numero_habitacion', $d?->numero_habitacion ?? 0) }}" min="0" class="{{ $input }}">
                </div>

                {{-- 12. Baños --}}
                <div>
                    <label class="{{ $label }}">Baños</label>
                    <input type="number" name="detalle[numero_bano]" value="{{ old('detalle.numero_bano', $d?->numero_bano ?? 0) }}" min="0" class="{{ $input }}">
                </div>

                {{-- 13. Parqueaderos --}}
                <div>
                    <label class="{{ $label }}">Parqueaderos</label>
                    <input type="number" name="detalle[numero_parqueadero]" value="{{ old('detalle.numero_parqueadero', $d?->numero_parqueadero ?? 0) }}" min="0" class="{{ $input }}">
                </div>

                {{-- 14. Piso --}}
                <div>
                    <label class="{{ $label }}">Piso</label>
                    <input type="number" name="detalle[numero_piso]" value="{{ old('detalle.numero_piso', $d?->numero_piso ?? '') }}" class="{{ $input }}">
                </div>

                {{-- 15. Apartamento --}}
                <div>
                    <label class="{{ $label }}">Apartamento</label>
                    <input type="number" name="detalle[numero_apartamento]" value="{{ old('detalle.numero_apartamento', $d?->numero_apartamento ?? '') }}" class="{{ $input }}">
                </div>

                {{-- 16. Descripción --}}
                <div class="md:col-span-2">
                    <label class="{{ $label }}">Descripción <span class="text-rose-400">*</span></label>
                    <textarea name="detalle[descripcion]" rows="4" required class="{{ $input }}">{{ old('detalle.descripcion', $d?->descripcion ?? '') }}</textarea>
                </div>
            </div>
        </section>

        {{-- 3. IMÁGENES --}}
        <section class="bg-neutral-900/90 border border-neutral-800 rounded-2xl shadow-xl p-5 sm:p-6 backdrop-blur-md">
            <div class="flex items-center justify-between mb-4 pb-2 border-b border-neutral-800">
                <div>
                    <h3 class="text-lg font-bold text-white">Galería de Imágenes</h3>
                    <p class="text-xs text-neutral-400">Administra las fotos actuales o agrega nuevas imágenes al inmueble.</p>
                </div>
                <span id="contador-fotos" class="hidden text-xs font-semibold px-2.5 py-1 bg-blue-950/80 text-blue-300 rounded-full border border-blue-800/80">
                    0 / 10 fotos nuevas
                </span>
            </div>

            {{-- Fotos publicadas actualmente en base de datos --}}
            @if ($inmueble->imagenes->isNotEmpty())
                <div class="mb-6">
                    <label class="block text-xs font-bold uppercase tracking-wider text-neutral-400 mb-2">
                        Fotos publicadas actualmente ({{ $inmueble->imagenes->count() }})
                    </label>
                    <div class="grid grid-cols-2 sm:grid-cols-4 gap-3">
                        @foreach ($inmueble->imagenes as $img)
                            <div class="relative group rounded-xl overflow-hidden border border-neutral-800 bg-neutral-950 shadow-xs">
                                <div class="aspect-4/3 w-full bg-neutral-950 overflow-hidden relative">
                                    <img src="{{ asset('storage/' . ($img->url_imagen ?? $img->ruta_imagen)) }}" class="w-full h-28 object-cover group-hover:scale-105 transition duration-200">
                                    @if ($loop->first)
                                        <span class="absolute top-2 left-2 bg-amber-500 text-white text-[10px] font-bold px-2 py-0.5 rounded-full shadow-md flex items-center gap-1 z-10">
                                            <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                                            Portada
                                        </span>
                                    @endif
                                    <button type="submit"
                                            form="eliminar-imagen-{{ $img->id }}"
                                            onclick="return confirm('¿Eliminar esta imagen del inmueble?')"
                                            class="absolute top-2 right-2 w-7 h-7 bg-rose-600/90 hover:bg-rose-700 text-white rounded-full flex items-center justify-center shadow-lg transition transform hover:scale-110 cursor-pointer z-10"
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
            <label class="block text-xs font-bold uppercase tracking-wider text-neutral-400 mb-2">
                Agregar más imágenes
            </label>
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
                        Arrastra y suelta fotos nuevas aquí, o <span class="text-blue-400 underline font-bold">haz clic para explorar</span>
                    </p>
                    <p class="text-xs text-neutral-500">
                        Hasta 10 fotos nuevas por carga (máx. 5 MB c/u en JPG, PNG o WEBP).
                    </p>
                </div>
            </div>

            {{-- Vista previa de las fotos nuevas seleccionadas --}}
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

<script>
    (function () {
        // Filtrar barrios dinámicamente según el municipio seleccionado
        const selectMunicipio = document.getElementById('id_municipio');
        const selectBarrio = document.getElementById('id_barrio');
        if (selectMunicipio && selectBarrio) {
            function filtrarBarrios() {
                const munId = selectMunicipio.value;
                const opciones = selectBarrio.querySelectorAll('option');

                opciones.forEach(opt => {
                    const munOpt = opt.getAttribute('data-municipio');
                    if (!munOpt) {
                        opt.style.display = '';
                    } else if (!munId || munOpt === munId) {
                        opt.style.display = '';
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
                contadorFotos.textContent = `${total} / 10 fotos nuevas`;
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

@endsection
