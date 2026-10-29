<!DOCTYPE html>
<html lang="es" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Inmobirovira') | Inmobirovira</title>
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
</head>
<body class="bg-neutral-950 text-neutral-100 min-h-screen flex flex-col antialiased selection:bg-blue-600 selection:text-white">

    {{-- ENCABEZADO SUPERIOR DARK LUXURY --}}
    @hasSection('header_transparent')
        {{-- MODO TRANSPARENTE: FLOTA SOBRE LA IMAGEN DEL HERO --}}
        <header class="absolute top-0 left-0 right-0 z-50 bg-gradient-to-b from-black/90 via-black/50 to-transparent">
            <div class="max-w-7xl mx-auto px-4 py-4 sm:py-5 flex items-center justify-between gap-4">

                {{-- Logo Izquierda: Opción Platino Perla --}}
                <a href="{{ route('inicio') }}" class="flex items-center gap-3 shrink-0 group">
                    <svg class="w-10 h-10 drop-shadow-md" viewBox="0 0 48 48" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <circle cx="24" cy="24" r="21" stroke="#cbd5e1" stroke-width="2" stroke-dasharray="2 3" />
                        <path d="M13 26L24 16L35 26" stroke="#ffffff" stroke-width="3" stroke-linecap="round" stroke-linejoin="round" />
                        <path d="M17 25V33C17 34.1 17.9 35 19 35H29C30.1 35 31 34.1 31 33V25" stroke="#94a3b8" stroke-width="2.5" stroke-linecap="round" />
                        <path d="M24 35V29" stroke="#ffffff" stroke-width="2.5" stroke-linecap="round" />
                    </svg>
                    <div class="leading-none">
                        <span class="text-xl font-black tracking-tight text-white drop-shadow-md">Inmobi<span class="text-slate-300 font-light">rovira</span></span>
                    </div>
                </a>

                {{-- Cápsula Central Oscura Traslúcida --}}
                <nav class="hidden md:flex items-center bg-neutral-900/90 backdrop-blur-md p-1 rounded-full border border-neutral-800 shadow-2xl text-sm font-semibold">
                    <a href="{{ route('inicio', ['tipo_oferta' => 'arriendo']) }}#inmuebles"
                       class="px-5 py-1.5 rounded-full transition {{ request('tipo_oferta') === 'arriendo' ? 'bg-blue-600 text-white shadow-xs' : 'text-neutral-400 hover:text-white' }}">
                        Arriendo
                    </a>
                    <a href="{{ route('inicio', ['tipo_oferta' => 'venta']) }}#inmuebles"
                       class="px-5 py-1.5 rounded-full transition {{ request('tipo_oferta') === 'venta' ? 'bg-blue-600 text-white shadow-xs' : 'text-neutral-400 hover:text-white' }}">
                        Venta
                    </a>
                    <a href="{{ route('inicio') }}#inmuebles"
                       class="px-5 py-1.5 rounded-full transition {{ empty(request('tipo_oferta')) ? 'bg-blue-600 text-white shadow-xs' : 'text-neutral-400 hover:text-white' }}">
                        Inmuebles
                    </a>
                </nav>

                {{-- Botón Derecho: Acceso al Sistema Inteligente --}}
                <div class="flex items-center gap-3">
                    @auth
                        @php
                            $rutaPanel = auth()->user()?->hasRole(config('seguridad.rol_admin', 'administrador'))
                                ? route('dashboard.index')
                                : route('empresa.index');
                        @endphp
                        <div class="flex items-center gap-2">
                            <a href="{{ $rutaPanel }}"
                               class="inline-flex items-center gap-2 px-5 py-2.5 rounded-full bg-blue-600 hover:bg-blue-700 text-white text-xs sm:text-sm font-bold shadow-lg shadow-blue-600/40 transition transform hover:scale-102 cursor-pointer">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                                </svg>
                                <span>{{ auth()->user()?->hasRole(config('seguridad.rol_admin', 'administrador')) ? 'Panel Admin' : 'Mi Portal' }}</span>
                            </a>
                            <form method="POST" action="{{ route('logout') }}" class="inline">
                                @csrf
                                <button type="submit"
                                        class="p-2.5 rounded-full bg-neutral-900/80 hover:bg-neutral-800 text-neutral-400 hover:text-rose-400 border border-neutral-800 backdrop-blur-md transition cursor-pointer"
                                        title="Cerrar sesión">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                                    </svg>
                                </button>
                            </form>
                        </div>
                    @else
                        <a href="{{ route('login') }}"
                           class="inline-flex items-center justify-center px-6 py-2.5 rounded-full bg-blue-600 hover:bg-blue-700 text-white text-xs sm:text-sm font-bold shadow-lg shadow-blue-600/40 transition transform hover:scale-105 cursor-pointer">
                            Iniciar sesión
                        </a>
                    @endauth

                    {{-- Menú móvil desplegable --}}
                    <details class="md:hidden relative">
                        <summary class="list-none cursor-pointer p-2 rounded-xl bg-neutral-900/80 text-white border border-neutral-800 backdrop-blur-md">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" class="w-5 h-5">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                            </svg>
                        </summary>

                        <nav class="absolute right-0 top-full mt-2 w-52 bg-neutral-900 border border-neutral-800 rounded-2xl shadow-2xl p-2 space-y-1 text-sm font-semibold z-50">
                            @auth
                                <div class="px-4 py-2 border-b border-neutral-800 text-xs text-neutral-400">
                                    Conectado como <span class="font-bold text-white block truncate">{{ auth()->user()->name ?? 'Administrador' }}</span>
                                </div>
                                <a href="{{ $rutaPanel ?? (auth()->user()?->hasRole(config('seguridad.rol_admin', 'administrador')) ? route('dashboard.index') : route('empresa.index')) }}" class="block px-4 py-2 rounded-lg text-blue-400 hover:bg-neutral-800 font-semibold">{{ auth()->user()?->hasRole(config('seguridad.rol_admin', 'administrador')) ? 'Ir al Panel Admin' : 'Ir a Mi Portal Empresa' }}</a>
                            @endauth
                            <a href="{{ route('inicio', ['tipo_oferta' => 'arriendo']) }}#inmuebles" class="block px-4 py-2 rounded-lg text-neutral-300 hover:bg-neutral-800 hover:text-white">Arriendo</a>
                            <a href="{{ route('inicio', ['tipo_oferta' => 'venta']) }}#inmuebles" class="block px-4 py-2 rounded-lg text-neutral-300 hover:bg-neutral-800 hover:text-white">Venta</a>
                            <a href="{{ route('inicio') }}#inmuebles" class="block px-4 py-2 rounded-lg text-neutral-300 hover:bg-neutral-800 hover:text-white">Todos los inmuebles</a>
                            <a href="#contacto" class="block px-4 py-2 rounded-lg text-neutral-300 hover:bg-neutral-800 hover:text-white">Contacto</a>
                            @auth
                                <div class="border-t border-neutral-800 pt-1 mt-1">
                                    <form method="POST" action="{{ route('logout') }}">
                                        @csrf
                                        <button type="submit" class="w-full text-left px-4 py-2 rounded-lg text-rose-400 hover:bg-neutral-800 text-sm font-semibold">Cerrar sesión</button>
                                    </form>
                                </div>
                            @else
                                <div class="border-t border-neutral-800 pt-1 mt-1">
                                    <a href="{{ route('login') }}" class="block px-4 py-2 rounded-lg text-blue-400 hover:bg-neutral-800 font-semibold">Iniciar sesión</a>
                                </div>
                            @endauth
                        </nav>
                    </details>
                </div>
            </div>
        </header>
    @else
        {{-- MODO REGULAR OSCURO ELEGANTE PARA PÁGINAS INTERNAS --}}
        <header class="bg-neutral-950/95 backdrop-blur-md border-b border-neutral-800/80 sticky top-0 z-50 shadow-md">
            <div class="max-w-7xl mx-auto px-4 py-3.5 flex items-center justify-between gap-4">
                <a href="{{ route('inicio') }}" class="flex items-center gap-3 shrink-0 group">
                    <svg class="w-10 h-10" viewBox="0 0 48 48" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <circle cx="24" cy="24" r="21" stroke="#cbd5e1" stroke-width="2" stroke-dasharray="2 3" />
                        <path d="M13 26L24 16L35 26" stroke="#ffffff" stroke-width="3" stroke-linecap="round" stroke-linejoin="round" />
                        <path d="M17 25V33C17 34.1 17.9 35 19 35H29C30.1 35 31 34.1 31 33V25" stroke="#94a3b8" stroke-width="2.5" stroke-linecap="round" />
                        <path d="M24 35V29" stroke="#ffffff" stroke-width="2.5" stroke-linecap="round" />
                    </svg>
                    <div class="leading-none">
                        <span class="text-xl font-black tracking-tight text-white">Inmobi<span class="text-slate-300 font-light">rovira</span></span>
                    </div>
                </a>

                <nav class="hidden md:flex items-center bg-neutral-900 p-1 rounded-full border border-neutral-800 text-sm font-semibold">
                    <a href="{{ route('inicio', ['tipo_oferta' => 'arriendo']) }}#inmuebles" class="px-5 py-1.5 rounded-full transition {{ request('tipo_oferta') === 'arriendo' ? 'bg-blue-600 text-white' : 'text-neutral-400 hover:text-white' }}">Arriendo</a>
                    <a href="{{ route('inicio', ['tipo_oferta' => 'venta']) }}#inmuebles" class="px-5 py-1.5 rounded-full transition {{ request('tipo_oferta') === 'venta' ? 'bg-blue-600 text-white' : 'text-neutral-400 hover:text-white' }}">Venta</a>
                    <a href="{{ route('inicio') }}#inmuebles" class="px-5 py-1.5 rounded-full transition {{ empty(request('tipo_oferta')) ? 'bg-blue-600 text-white' : 'text-neutral-400 hover:text-white' }}">Inmuebles</a>
                </nav>

                <div class="flex items-center gap-3">
                    @auth
                        <div class="flex items-center gap-2">
                            <a href="{{ route('dashboard.index') }}"
                               class="inline-flex items-center gap-2 px-5 py-2 rounded-full bg-blue-600 hover:bg-blue-700 text-white text-xs sm:text-sm font-bold shadow-lg shadow-blue-600/40 transition transform hover:scale-102 cursor-pointer">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                                </svg>
                                <span>Panel</span>
                            </a>
                            <form method="POST" action="{{ route('logout') }}" class="inline">
                                @csrf
                                <button type="submit"
                                        class="p-2 rounded-full bg-neutral-900 hover:bg-neutral-800 text-neutral-400 hover:text-rose-400 border border-neutral-800 transition cursor-pointer"
                                        title="Cerrar sesión">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                                    </svg>
                                </button>
                            </form>
                        </div>
                    @else
                        <a href="{{ route('login') }}" class="inline-flex items-center justify-center px-6 py-2.5 rounded-full bg-blue-600 hover:bg-blue-700 text-white text-xs sm:text-sm font-bold shadow-lg shadow-blue-600/40 transition transform hover:scale-105 cursor-pointer">
                            Iniciar sesión
                        </a>
                    @endauth
                </div>
            </div>
        </header>
    @endif

    {{-- HERO / BANNER PRINCIPAL --}}
    @yield('hero')

    {{-- MENSAJES --}}
    @if (session('success'))
        <div class="max-w-7xl mx-auto w-full px-4 mt-6">
            <div class="bg-emerald-950/60 border border-emerald-500/40 text-emerald-300 px-4 py-3 rounded-xl shadow-xs">
                {{ session('success') }}
            </div>
        </div>
    @endif

    {{-- CONTENIDO --}}
    <main class="flex-1 max-w-7xl mx-auto w-full px-4 py-8">
        @yield('content')
    </main>

    {{-- PIE DE PÁGINA OSCURO --}}
    <footer id="contacto" class="bg-black text-neutral-400 mt-20 border-t border-neutral-900">
        <div class="max-w-7xl mx-auto px-4 py-12 grid grid-cols-1 md:grid-cols-3 gap-8">

            <div>
                <div class="flex items-center gap-3 mb-4">
                    <svg class="w-10 h-10" viewBox="0 0 48 48" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <circle cx="24" cy="24" r="21" stroke="#cbd5e1" stroke-width="2" stroke-dasharray="2 3" />
                        <path d="M13 26L24 16L35 26" stroke="#ffffff" stroke-width="3" stroke-linecap="round" stroke-linejoin="round" />
                        <path d="M17 25V33C17 34.1 17.9 35 19 35H29C30.1 35 31 34.1 31 33V25" stroke="#94a3b8" stroke-width="2.5" stroke-linecap="round" />
                        <path d="M24 35V29" stroke="#ffffff" stroke-width="2.5" stroke-linecap="round" />
                    </svg>
                    <div class="leading-none">
                        <span class="text-xl font-black tracking-tight text-white">Inmobi<span class="text-slate-300 font-light">rovira</span></span>
                    </div>
                </div>
                <p class="text-sm text-neutral-400 leading-relaxed">
                    Tu portal de confianza para encontrar casas, apartamentos, fincas y locales en venta y arriendo en la provincia de García Rovira, Santander.
                </p>
            </div>

            <div>
                <h3 class="text-white font-semibold mb-3">Navegación</h3>
                <ul class="space-y-2 text-sm">
                    <li><a href="{{ route('inicio') }}" class="hover:text-white transition">Inicio</a></li>
                    <li><a href="{{ route('inicio', ['tipo_oferta' => 'venta']) }}#inmuebles" class="hover:text-white transition">Inmuebles en Venta</a></li>
                    <li><a href="{{ route('inicio', ['tipo_oferta' => 'arriendo']) }}#inmuebles" class="hover:text-white transition">Inmuebles en Arriendo</a></li>
                </ul>
            </div>

            <div>
                <h3 class="text-white font-semibold mb-3">Contacto</h3>
                <ul class="space-y-2 text-sm text-neutral-400">
                    <li>Málaga, Santander</li>
                    <li>contacto@inmobirovira.com</li>
                    <li>
                        <a href="https://wa.me/{{ config('services.whatsapp.numero', '573103451093') }}"
                           target="_blank"
                           rel="noopener noreferrer"
                           class="hover:text-emerald-400 transition inline-flex items-center gap-1.5">
                            <span class="w-2 h-2 rounded-full bg-emerald-500 inline-block"></span>
                            {{ config('services.whatsapp.numero_visible', '+57 310 345 1093') }}
                        </a>
                    </li>
                </ul>
            </div>

        </div>

        <div class="border-t border-neutral-900">
            <div class="max-w-7xl mx-auto px-4 py-4 text-center text-xs text-neutral-500">
                © {{ date('Y') }} Inmobirovira. Todos los derechos reservados.
            </div>
        </div>
    </footer>

    {{-- Botón Flotante Global de WhatsApp --}}
    <x-publico.boton-whatsapp-flotante />

</body>
</html>
