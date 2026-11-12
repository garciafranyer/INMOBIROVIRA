<header class="sticky top-0 z-20 bg-white/90 backdrop-blur-md border-b border-slate-200/80 shadow-xs">
    <div class="h-20 px-4 sm:px-6 lg:px-8 flex items-center justify-between gap-4">

        <div class="flex items-center gap-4 min-w-0">
            {{-- Botón menú móvil --}}
            <button
                @click="sidebarOpen = !sidebarOpen"
                type="button"
                class="lg:hidden p-2.5 rounded-xl text-slate-600 hover:bg-slate-100 hover:text-slate-900 focus:outline-none focus:ring-2 focus:ring-blue-500"
                aria-label="Abrir menú lateral"
            >
                <span class="w-6 h-6 block">@include('layouts.partials.icons', ['icon' => 'menu'])</span>
            </button>

            <div class="min-w-0">
                <div class="flex items-center gap-2">
                    <span class="text-xs font-bold text-slate-400 uppercase tracking-wider hidden sm:inline">InmobiRovira</span>
                    <span class="text-slate-300 hidden sm:inline">•</span>
                    <h1 class="text-base sm:text-lg font-black text-slate-900 truncate">
                        @yield('page-title', 'Dashboard')
                    </h1>
                </div>
            </div>
        </div>

        <div class="flex items-center gap-2 sm:gap-4">

            {{-- Botón rápido: Ir al portal público --}}
            <a
                href="{{ route('inicio') }}"
<<<<<<< HEAD
                
=======
>>>>>>> 566ac90 (se agrego mensaje de error a la hora de eliminar un campo que tenga un inmueble creado, tambien se agrego advertencia de numeros negativos en precio y se arreglaron las redireciones de whatsApp)
                class="hidden sm:inline-flex items-center gap-1.5 px-3.5 py-2 rounded-xl text-xs font-bold text-slate-700 bg-slate-100 hover:bg-slate-200 border border-slate-200 transition"
            >
                <svg class="w-4 h-4 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/></svg>
                <span>Ver Portal Web</span>
            </a>

            @php
                $pendientesNav = \App\Models\Inmueble::whereHas('detalle_inmueble', fn($q) => $q->where('estado_publicacion', 'pendiente'))->count();
            @endphp

            {{-- Campana de Notificaciones / Moderación --}}
            <div x-data="{ open: false }" class="relative">
                <button
                    @click="open = !open"
                    @click.outside="open = false"
                    type="button"
                    class="relative p-2.5 rounded-xl text-slate-600 hover:bg-slate-100 hover:text-slate-900 focus:outline-none focus:ring-2 focus:ring-blue-500 transition"
                    aria-label="Ver notificaciones"
                >
                    <span class="w-5 h-5 block">@include('layouts.partials.icons', ['icon' => 'bell'])</span>
                    @if ($pendientesNav > 0)
                        <span class="absolute top-1.5 right-1.5 w-2.5 h-2.5 rounded-full bg-amber-500 ring-2 ring-white animate-pulse"></span>
                    @endif
                </button>

                <div
                    x-show="open" x-cloak
                    x-transition
                    class="absolute right-0 mt-2 w-80 bg-white rounded-2xl shadow-2xl border border-slate-200/90 overflow-hidden z-50"
                >
                    <div class="px-4 py-3.5 border-b border-slate-100 font-bold text-sm text-slate-800 flex items-center justify-between">
                        <span>Notificaciones</span>
                        @if ($pendientesNav > 0)
                            <span class="px-2 py-0.5 text-[10px] font-black rounded-full bg-amber-100 text-amber-800 border border-amber-200">
                                {{ $pendientesNav }} pendiente{{ $pendientesNav > 1 ? 's' : '' }}
                            </span>
                        @endif
                    </div>
                    <ul class="max-h-72 overflow-y-auto divide-y divide-slate-100">
                        @if ($pendientesNav > 0)
                            <li class="p-3.5 bg-amber-50/60 hover:bg-amber-50 transition">
                                <a href="{{ route('inmueble.index') }}" class="block">
                                    <div class="flex items-center gap-2">
                                        <span class="w-2 h-2 rounded-full bg-amber-500"></span>
                                        <p class="text-xs font-bold text-amber-950">Inmuebles por Autorizar</p>
                                    </div>
                                    <p class="text-xs text-amber-900 mt-1">
                                        Hay {{ $pendientesNav }} publicación(es) de usuarios particulares esperando tu revisión.
                                    </p>
                                    <span class="text-[11px] font-bold text-amber-700 mt-1.5 inline-block">Revisar ahora &rarr;</span>
                                </a>
                            </li>
                        @else
                            <li class="px-4 py-6 text-xs text-slate-400 text-center flex flex-col items-center justify-center gap-1">
                                <svg class="w-6 h-6 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                                <span>Todo al día. No hay pendientes.</span>
                            </li>
                        @endif
                    </ul>
                </div>
            </div>

            {{-- Menú de usuario Administrador --}}
            <div x-data="{ open: false }" class="relative">
                <button
                    @click="open = !open"
                    @click.outside="open = false"
                    type="button"
                    class="flex items-center gap-2.5 p-1.5 sm:px-3 sm:py-2 rounded-2xl hover:bg-slate-100 border border-transparent hover:border-slate-200 focus:outline-none focus:ring-2 focus:ring-blue-500 transition"
                    aria-haspopup="true"
                    :aria-expanded="open.toString()"
                >
                    <div class="w-8 h-8 rounded-xl bg-linear-to-tr from-blue-600 to-indigo-600 text-white font-bold text-xs flex items-center justify-center shadow-sm">
                        {{ strtoupper(substr(auth()->user()->nombre ?? auth()->user()->name ?? 'A', 0, 1)) }}
                    </div>
                    <div class="hidden sm:block text-left">
                        <span class="block text-xs font-bold text-slate-800 leading-tight">
                            {{ auth()->user()->nombre ?? auth()->user()->name ?? 'Administrador' }}
                        </span>
                        <span class="block text-[10px] font-semibold text-blue-600">
                            Administrador General
                        </span>
                    </div>
                    <span class="w-3.5 h-3.5 text-slate-400 hidden sm:block">@include('layouts.partials.icons', ['icon' => 'chevron-down'])</span>
                </button>

                <div
                    x-show="open" x-cloak
                    x-transition
                    class="absolute right-0 mt-2 w-56 bg-white rounded-2xl shadow-2xl border border-slate-200/90 overflow-hidden py-1.5 z-50"
                >
                    <div class="px-4 py-2.5 border-b border-slate-100">
                        <p class="text-xs font-bold text-slate-800">{{ auth()->user()->nombre ?? auth()->user()->name ?? 'Administrador' }}</p>
                        <p class="text-[11px] text-slate-400 truncate">{{ auth()->user()->email ?? '' }}</p>
                    </div>

                    <a href="{{ route('inmueble.index') }}" class="flex items-center gap-2 px-4 py-2 text-xs font-medium text-slate-700 hover:bg-slate-50 transition">
                        <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg>
                        <span>Gestionar Inmuebles</span>
                    </a>

                    <a href="{{ route('seguridad.roles.index') }}" class="flex items-center gap-2 px-4 py-2 text-xs font-medium text-slate-700 hover:bg-slate-50 transition">
                        <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/></svg>
                        <span>Roles y Permisos</span>
                    </a>

                    <hr class="my-1 border-slate-100">

                    <form method="POST" action="{{ Route::has('logout') ? route('logout') : '#' }}">
                        @csrf
                        <button type="submit" class="w-full flex items-center gap-2 px-4 py-2 text-xs font-bold text-rose-600 hover:bg-rose-50 transition cursor-pointer">
                            <svg class="w-4 h-4 text-rose-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/></svg>
                            <span>Cerrar sesión</span>
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</header>
