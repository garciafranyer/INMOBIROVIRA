{{--
    Sidebar principal del Administrador.
    Diseño profesional para InmobiRovira con navegación agrupada y badge de moderación en tiempo real.
--}}
<aside
    x-cloak
    :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full lg:translate-x-0'"
    class="fixed inset-y-0 left-0 z-40 w-64 bg-slate-950 text-slate-300 border-r border-slate-800/80 transform transition-transform duration-200 ease-in-out lg:translate-x-0 flex flex-col justify-between shadow-2xl"
    aria-label="Menú principal"
>
    <div class="h-full flex flex-col min-h-0">

        {{-- Logo Oficial InmobiRovira & Brand Header --}}
        <div class="flex items-center justify-between h-20 px-5 border-b border-slate-800/80 bg-slate-950/60 backdrop-blur-md shrink-0">
            <x-logo :href="route('dashboard.index')" size="sm" badge="Admin Panel" />

            {{-- Botón de cerrar en móvil --}}
            <button @click="sidebarOpen = false" class="lg:hidden text-slate-400 hover:text-white p-1 rounded-lg">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
            </button>
        </div>

        {{-- Navegación agrupada --}}
        <nav class="flex-1 overflow-y-auto px-3 py-5 space-y-6 scrollbar-thin scrollbar-thumb-slate-800" aria-label="Navegación lateral">

            @php
                $cantPendientes = \App\Models\Inmueble::whereHas('detalle_inmueble', fn($q) => $q->where('estado_publicacion', 'pendiente'))->count();

                $secciones = [
                    [
                        'titulo' => 'Principal',
                        'items' => [
                            ['label' => 'Dashboard', 'route' => 'dashboard.index', 'icon' => 'home'],
                            ['label' => 'Inmuebles', 'route' => 'inmueble.index', 'icon' => 'building-office-2', 'badge' => $cantPendientes],
                        ]
                    ],
                    [
                        'titulo' => 'Catálogos & Territorio',
                        'items' => [
                            ['label' => 'Municipios', 'route' => 'municipio.index', 'icon' => 'map'],
                            ['label' => 'Barrios & Veredas', 'route' => 'barrio.index', 'icon' => 'map-pin'],
                            ['label' => 'Tipos de Inmueble', 'route' => 'tipo_inmueble.index', 'icon' => 'tag'],
                        ]
                    ],
                    [
                        'titulo' => 'Seguridad & Acceso',
                        'items' => [
                            ['label' => 'Usuarios', 'route' => 'usuario.index', 'icon' => 'users'],
                            ['label' => 'Roles & Permisos', 'route' => 'seguridad.roles.index', 'icon' => 'shield'],
                        ]
                    ],
                ];
            @endphp

            @foreach ($secciones as $seccion)
                <div>
                    <h3 class="px-3 text-[11px] font-black uppercase tracking-wider text-slate-400 mb-2">
                        {{ $seccion['titulo'] }}
                    </h3>

                    <div class="space-y-1">
                        @foreach ($seccion['items'] as $item)
                            @php
                                $routeName = explode('.', $item['route'])[0];
                                $active = Route::has($item['route']) && (
                                    request()->routeIs($routeName . '.*') ||
                                    (str_starts_with($item['route'], 'seguridad.') && request()->routeIs('seguridad.*'))
                                );
                            @endphp

                            <a
                                href="{{ Route::has($item['route']) ? route($item['route']) : '#' }}"
                                @if($active) aria-current="page" @endif
                                class="group flex items-center justify-between px-3 py-2.5 rounded-xl text-xs font-semibold transition-all duration-150
                                    {{ $active
                                        ? 'bg-blue-600 text-white shadow-md shadow-blue-600/30'
                                        : 'text-slate-400 hover:bg-slate-900 hover:text-white' }}"
                            >
                                <div class="flex items-center gap-3 min-w-0">
                                    <span class="w-4 h-4 shrink-0 transition {{ $active ? 'text-white' : 'text-slate-400 group-hover:text-blue-400' }}">
                                        @include('layouts.partials.icons', ['icon' => $item['icon']])
                                    </span>
                                    <span class="truncate">{{ $item['label'] }}</span>
                                </div>

                                {{-- Badge de pendientes --}}
                                @if (!empty($item['badge']) && $item['badge'] > 0)
                                    <span class="ml-2 px-2 py-0.5 text-[10px] font-black rounded-full bg-amber-500 text-white shadow-sm animate-pulse">
                                        {{ $item['badge'] }}
                                    </span>
                                @endif
                            </a>
                        @endforeach
                    </div>
                </div>
            @endforeach
        </nav>

        {{-- Opciones Inferiores: Ver Portal Público & Salir --}}
        <div class="p-3 border-t border-slate-800/80 bg-slate-950/40 space-y-2 shrink-0">
            <a
                href="{{ route('inicio') }}"
                target="_blank"
                rel="noopener noreferrer"
                class="flex items-center justify-between px-3 py-2.5 rounded-xl text-xs font-semibold text-slate-300 bg-slate-900/90 hover:bg-slate-800 hover:text-white border border-slate-800 transition"
                title="Ir al portal público (Abre en pestaña nueva)"
            >
                <div class="flex items-center gap-2">
                    <span  class="w-2 h-2 rounded-full bg-emerald-400 animate-ping"></span>
                    <span>Portal Público</span>
                </div>
                <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/></svg>
            </a>

            <form method="POST" action="{{ Route::has('logout') ? route('logout') : '#' }}">
                @csrf
                <button
                    type="submit"
                    class="w-full flex items-center justify-center gap-2 px-3 py-2 rounded-xl text-xs font-bold text-rose-300 hover:bg-rose-950/40 hover:text-rose-200 border border-transparent hover:border-rose-900/60 transition cursor-pointer"
                >
                    <svg class="w-4 h-4 text-rose-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/></svg>
                    <span>Cerrar sesión</span>
                </button>
            </form>
        </div>
    </div>
</aside>
