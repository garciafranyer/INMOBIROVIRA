@extends('layouts.empresa')

@section('title', 'Editar inmueble: ' . $inmueble->nombre)

@section('content')

@php
    $input = 'w-full border border-slate-300 rounded-xl px-3.5 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-400 focus:border-indigo-400 bg-white transition';
    $label = 'block mb-1.5 text-xs font-bold uppercase tracking-wider text-slate-600';
    $d = $inmueble->detalle_inmueble;
@endphp

<div class="max-w-4xl mx-auto">

    <div class="mb-6 flex items-center justify-between">
        <div>
            <a href="{{ route('empresa.index') }}" class="text-xs font-semibold text-indigo-600 hover:text-indigo-800 flex items-center gap-1 mb-1">
                &larr; Volver a mis inmuebles
            </a>
            <h1 class="text-2xl font-black text-slate-900">Editar inmueble</h1>
            <p class="text-xs text-slate-500">Actualiza las características, precios, estado o imágenes de tu propiedad.</p>
        </div>

        <a href="{{ route('propiedad.show', $inmueble->id) }}" target="_blank"
           class="inline-flex items-center gap-1.5 px-4 py-2 rounded-xl border border-slate-300 text-xs font-bold text-slate-700 hover:bg-slate-50 transition">
            <span>Ver cómo se ve en la web</span>
            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/></svg>
        </a>
    </div>

    {{-- Errores de validación --}}
    @if ($errors->any())
        <div class="bg-rose-50 border border-rose-200 text-rose-800 p-4 rounded-xl mb-6 text-sm">
            <p class="font-bold mb-1">Por favor corrige los siguientes campos:</p>
            <ul class="list-disc list-inside text-xs space-y-0.5">
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

        {{-- 1. DATOS BÁSICOS --}}
        <section class="bg-white border border-slate-200 rounded-2xl shadow-xs p-6">
            <h2 class="text-base font-bold text-slate-900 mb-4 pb-2 border-b border-slate-100 flex items-center gap-2">
                <span class="w-6 h-6 rounded-lg bg-indigo-50 text-indigo-600 flex items-center justify-center text-xs font-black">1</span>
                <span>Datos principales</span>
            </h2>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div class="md:col-span-2">
                    <label class="{{ $label }}">Nombre del inmueble <span class="text-rose-500">*</span></label>
                    <input type="text" name="nombre" value="{{ old('nombre', $inmueble->nombre) }}" required class="{{ $input }}">
                </div>

                <div>
                    <label class="{{ $label }}">Tipo de inmueble <span class="text-rose-500">*</span></label>
                    <select name="id_tipo_inmueble" required class="{{ $input }}">
                        @foreach ($tipo_inmueble as $tipo)
                            <option value="{{ $tipo->id }}" @selected(old('id_tipo_inmueble', $inmueble->id_tipo_inmueble) == $tipo->id)>{{ $tipo->nombre }}</option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="{{ $label }}">Zona <span class="text-rose-500">*</span></label>
                    <select name="zona" id="zona" required class="{{ $input }}">
                        <option value="urbana" @selected(old('zona', $inmueble->zona) === 'urbana')>Urbana</option>
                        <option value="rural"  @selected(old('zona', $inmueble->zona) === 'rural')>Rural</option>
                    </select>
                </div>

                <div>
                    <label class="{{ $label }}">Municipio <span class="text-rose-500">*</span></label>
                    <select name="id_municipio" id="id_municipio" required class="{{ $input }}">
                        @foreach ($municipios as $m)
                            <option value="{{ $m->id }}" @selected(old('id_municipio', $inmueble->id_municipio) == $m->id)>{{ $m->nombre }}</option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="{{ $label }}">Barrio / Vereda</label>
                    <select name="id_barrio" id="id_barrio" class="{{ $input }}">
                        <option value="">Selecciona barrio (opcional)</option>
                        @foreach ($barrios as $b)
                            <option value="{{ $b->id }}" data-municipio="{{ $b->id_municipio }}" @selected(old('id_barrio', $inmueble->id_barrio) == $b->id)>
                                {{ $b->nombre }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="md:col-span-2">
                    <label class="{{ $label }}">Dirección exacta <span class="text-rose-500">*</span></label>
                    <input type="text" name="detalle[direccion]" value="{{ old('detalle.direccion', $d?->direccion) }}" required class="{{ $input }}">
                </div>
            </div>
        </section>

        {{-- 2. OFERTA Y PRECIOS --}}
        <section class="bg-white border border-slate-200 rounded-2xl shadow-xs p-6">
            <h2 class="text-base font-bold text-slate-900 mb-4 pb-2 border-b border-slate-100 flex items-center gap-2">
                <span class="w-6 h-6 rounded-lg bg-indigo-50 text-indigo-600 flex items-center justify-center text-xs font-black">2</span>
                <span>Precios, estado y tipo de oferta</span>
            </h2>

            <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                <div>
                    <label class="{{ $label }}">Tipo de oferta <span class="text-rose-500">*</span></label>
                    <select name="detalle[tipo_oferta]" required class="{{ $input }}">
                        <option value="arriendo" @selected(old('detalle.tipo_oferta', $d?->tipo_oferta) === 'arriendo')>Arriendo</option>
                        <option value="venta"    @selected(old('detalle.tipo_oferta', $d?->tipo_oferta) === 'venta')>Venta</option>
                        <option value="venta y arriendo" @selected(old('detalle.tipo_oferta', $d?->tipo_oferta) === 'venta y arriendo')>Venta y arriendo</option>
                    </select>
                </div>

                <div>
                    <label class="{{ $label }}">Estado de publicación <span class="text-rose-500">*</span></label>
                    <select name="detalle[estado_publicacion]" required class="{{ $input }}">
                        <option value="disponible" @selected(old('detalle.estado_publicacion', $d?->estado_publicacion) === 'disponible')>Disponible</option>
                        <option value="reservado"  @selected(old('detalle.estado_publicacion', $d?->estado_publicacion) === 'reservado')>Reservado</option>
                        <option value="arrendado"  @selected(old('detalle.estado_publicacion', $d?->estado_publicacion) === 'arrendado')>Arrendado</option>
                        <option value="vendido"    @selected(old('detalle.estado_publicacion', $d?->estado_publicacion) === 'vendido')>Vendido</option>
                        <option value="inactivo"   @selected(old('detalle.estado_publicacion', $d?->estado_publicacion) === 'inactivo')>Inactivo</option>
                    </select>
                </div>

                <div>
                    <label class="{{ $label }}">Precio ($ COP) <span class="text-rose-500">*</span></label>
                    <input type="number" name="detalle[precio]" value="{{ old('detalle.precio', $d?->precio) }}" min="0" required class="{{ $input }}">
                </div>

                <div>
                    <label class="{{ $label }}">Valor de administración ($)</label>
                    <input type="number" name="detalle[precio_administrador]" value="{{ old('detalle.precio_administrador', $d?->precio_administrador ?? 0) }}" min="0" class="{{ $input }}">
                </div>

                <input type="hidden" name="detalle[fecha_publicacion]" value="{{ old('detalle.fecha_publicacion', $d?->fecha_publicacion ?? date('Y-m-d')) }}">
            </div>
        </section>

        {{-- 3. CARACTERÍSTICAS --}}
        <section class="bg-white border border-slate-200 rounded-2xl shadow-xs p-6">
            <h2 class="text-base font-bold text-slate-900 mb-4 pb-2 border-b border-slate-100 flex items-center gap-2">
                <span class="w-6 h-6 rounded-lg bg-indigo-50 text-indigo-600 flex items-center justify-center text-xs font-black">3</span>
                <span>Características del inmueble</span>
            </h2>

            <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                <div>
                    <label class="{{ $label }}">Área (m²) <span class="text-rose-500">*</span></label>
                    <input type="number" name="detalle[area]" value="{{ old('detalle.area', $d?->area) }}" min="0" step="0.01" required class="{{ $input }}">
                </div>

                <div>
                    <label class="{{ $label }}">Habitaciones</label>
                    <input type="number" name="detalle[numero_habitacion]" value="{{ old('detalle.numero_habitacion', $d?->numero_habitacion ?? 0) }}" min="0" class="{{ $input }}">
                </div>

                <div>
                    <label class="{{ $label }}">Baños</label>
                    <input type="number" name="detalle[numero_bano]" value="{{ old('detalle.numero_bano', $d?->numero_bano ?? 0) }}" min="0" class="{{ $input }}">
                </div>

                <div>
                    <label class="{{ $label }}">Parqueaderos</label>
                    <input type="number" name="detalle[numero_parqueadero]" value="{{ old('detalle.numero_parqueadero', $d?->numero_parqueadero ?? 0) }}" min="0" class="{{ $input }}">
                </div>

                <div>
                    <label class="{{ $label }}">Piso</label>
                    <input type="number" name="detalle[numero_piso]" value="{{ old('detalle.numero_piso', $d?->numero_piso) }}" min="0" class="{{ $input }}">
                </div>

                <div>
                    <label class="{{ $label }}">Apartamento Nº</label>
                    <input type="number" name="detalle[numero_apartamento]" value="{{ old('detalle.numero_apartamento', $d?->numero_apartamento) }}" min="0" class="{{ $input }}">
                </div>

                <div>
                    <label class="{{ $label }}">Estrato</label>
                    <select name="detalle[estrato]" class="{{ $input }}">
                        <option value="">Selecciona</option>
                        @for ($i = 1; $i <= 6; $i++)
                            <option value="{{ $i }}" @selected(old('detalle.estrato', $d?->estrato) == $i)>Estrato {{ $i }}</option>
                        @endfor
                    </select>
                </div>

                <div>
                    <label class="{{ $label }}">¿Mascotas permitidas?</label>
                    <select name="detalle[mascotas_permitidas]" class="{{ $input }}">
                        <option value="1" @selected(old('detalle.mascotas_permitidas', (string)($d?->mascotas_permitidas ?? 1)) == '1')>Sí</option>
                        <option value="0" @selected(old('detalle.mascotas_permitidas', (string)($d?->mascotas_permitidas ?? 1)) == '0')>No</option>
                    </select>
                </div>

                <div class="col-span-2 md:col-span-4">
                    <label class="{{ $label }}">Antigüedad</label>
                    <input type="text" name="detalle[antiguedad]" value="{{ old('detalle.antiguedad', $d?->antiguedad) }}" placeholder="Ej: A estrenar, 5 años, Remodelado" class="{{ $input }}">
                </div>

                <div class="col-span-2 md:col-span-4">
                    <label class="{{ $label }}">Descripción <span class="text-rose-500">*</span></label>
                    <textarea name="detalle[descripcion]" rows="4" required class="{{ $input }}">{{ old('detalle.descripcion', $d?->descripcion) }}</textarea>
                </div>
            </div>
        </section>

        {{-- 4. FOTOGRAFÍAS EXISTENTES Y NUEVAS --}}
        <section class="bg-white border border-slate-200 rounded-2xl shadow-xs p-6">
            <h2 class="text-base font-bold text-slate-900 mb-4 pb-2 border-b border-slate-100 flex items-center gap-2">
                <span class="w-6 h-6 rounded-lg bg-indigo-50 text-indigo-600 flex items-center justify-center text-xs font-black">4</span>
                <span>Galería de fotografías</span>
            </h2>

            {{-- Fotos publicadas --}}
            @if ($inmueble->imagenes->isNotEmpty())
                <div class="mb-6">
                    <label class="block text-xs font-bold uppercase tracking-wider text-slate-600 mb-2">
                        Fotos actuales ({{ $inmueble->imagenes->count() }})
                    </label>
                    <div class="grid grid-cols-2 sm:grid-cols-4 gap-3">
                        @foreach ($inmueble->imagenes as $img)
                            <div class="relative group rounded-xl overflow-hidden border border-slate-200 bg-white shadow-xs">
                                <img src="{{ asset('storage/' . $img->url_imagen) }}" class="w-full h-28 object-cover">
                                @if ($loop->first)
                                    <span class="absolute top-1.5 left-1.5 text-[10px] font-bold px-2 py-0.5 rounded-full bg-amber-500 text-white shadow-xs">
                                        Portada
                                    </span>
                                @endif
                                <button type="submit"
                                        form="eliminar-foto-{{ $img->id }}"
                                        onclick="return confirm('¿Eliminar esta fotografía?');"
                                        class="absolute top-1.5 right-1.5 w-6 h-6 rounded-full bg-rose-600 hover:bg-rose-700 text-white flex items-center justify-center text-xs shadow-md cursor-pointer"
                                        title="Eliminar foto">
                                    ✕
                                </button>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif

            {{-- Agregar más fotos --}}
            <label class="block text-xs font-bold uppercase tracking-wider text-slate-600 mb-2">
                Agregar más fotos a este inmueble
            </label>
            <div id="dropzone" class="border-2 border-dashed border-slate-300 hover:border-indigo-500 bg-slate-50 hover:bg-indigo-50/40 rounded-2xl p-6 text-center transition cursor-pointer">
                <input type="file" name="imagenes[]" id="imagenes" multiple accept="image/*" class="hidden">
                <div class="w-10 h-10 rounded-xl bg-indigo-100 text-indigo-600 text-xl flex items-center justify-center mx-auto mb-2">
                    📷
                </div>
                <p class="font-bold text-xs text-slate-800">Haz clic aquí para seleccionar fotos adicionales</p>
                <p class="text-[10px] text-slate-400 mt-0.5">JPG, PNG, WEBP (máx. 5 MB por foto)</p>
                <span id="contador-fotos" class="inline-block mt-2 px-3 py-1 bg-indigo-600 text-white text-xs font-bold rounded-full hidden"></span>
            </div>

            <div id="vista-previa" class="grid grid-cols-2 sm:grid-cols-4 gap-3 mt-4"></div>
        </section>

        {{-- BOTONES DE ACCIÓN --}}
        <div class="flex items-center justify-end gap-3 pt-4">
            <a href="{{ route('empresa.index') }}"
               class="px-6 py-3 rounded-xl border border-slate-300 font-bold text-sm text-slate-700 hover:bg-slate-50 transition">
                Cancelar
            </a>
            <button type="submit"
                    class="px-8 py-3 rounded-xl bg-indigo-600 hover:bg-indigo-700 text-white font-bold text-sm shadow-lg shadow-indigo-600/30 transition transform hover:scale-102 cursor-pointer">
                ✓ Guardar Cambios
            </button>
        </div>
    </form>

    {{-- Formularios independientes para eliminar cada foto existente --}}
    @foreach ($inmueble->imagenes as $img)
        <form id="eliminar-foto-{{ $img->id }}" action="{{ route('imagen.destroy', $img->id) }}" method="POST" class="hidden">
            @csrf
            @method('DELETE')
        </form>
    @endforeach

</div>

{{-- SCRIPT: FILTRO DE BARRIOS Y SUBIDA DE FOTOS --}}
<script>
    (function () {
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

        dropzone.addEventListener('click', () => inputImagenes.click());

        ['dragenter', 'dragover'].forEach(eName => {
            dropzone.addEventListener(eName, (e) => {
                e.preventDefault();
                e.stopPropagation();
                dropzone.classList.add('border-indigo-600', 'bg-indigo-50');
            }, false);
        });

        ['dragleave', 'drop'].forEach(eName => {
            dropzone.addEventListener(eName, (e) => {
                e.preventDefault();
                e.stopPropagation();
                dropzone.classList.remove('border-indigo-600', 'bg-indigo-50');
            }, false);
        });

        dropzone.addEventListener('drop', (e) => {
            procesarArchivos(e.dataTransfer.files);
        });

        inputImagenes.addEventListener('change', function () {
            procesarArchivos(this.files);
        });

        function procesarArchivos(nuevos) {
            Array.from(nuevos).forEach(archivo => {
                if (!archivo.type.startsWith('image/')) return;
                if (dt.items.length >= 10) return;
                const yaExiste = Array.from(dt.files).some(f => f.name === archivo.name && f.size === archivo.size);
                if (!yaExiste) dt.items.add(archivo);
            });
            inputImagenes.files = dt.files;
            renderizar();
        }

        function renderizar() {
            vistaPrevia.innerHTML = '';
            const archivos = Array.from(dt.files);
            if (archivos.length > 0) {
                contadorFotos.classList.remove('hidden');
                contadorFotos.textContent = `${archivos.length} fotos nuevas seleccionadas`;
            } else {
                contadorFotos.classList.add('hidden');
            }

            archivos.forEach((f, idx) => {
                const card = document.createElement('div');
                card.className = 'relative group rounded-xl overflow-hidden border border-slate-200 bg-white shadow-xs';
                const url = URL.createObjectURL(f);
                card.innerHTML = `
                    <img src="${url}" class="w-full h-28 object-cover">
                    <button type="button" data-idx="${idx}" class="btn-del absolute top-1.5 right-1.5 w-6 h-6 rounded-full bg-rose-600 hover:bg-rose-700 text-white flex items-center justify-center text-xs shadow-md">✕</button>
                    <p class="p-1.5 text-[10px] text-slate-500 truncate">${f.name}</p>
                `;
                card.querySelector('.btn-del').addEventListener('click', (e) => {
                    e.stopPropagation();
                    const i = parseInt(e.currentTarget.getAttribute('data-idx'));
                    const nuevaDt = new DataTransfer();
                    Array.from(dt.files).forEach((item, k) => { if (k !== i) nuevaDt.items.add(item); });
                    dt = nuevaDt;
                    inputImagenes.files = dt.files;
                    renderizar();
                });
                vistaPrevia.appendChild(card);
            });
        }
    })();
</script>

@endsection
