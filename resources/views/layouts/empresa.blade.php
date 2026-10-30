<!DOCTYPE html>
<html lang="es" class="h-full bg-neutral-950">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Portal Empresa') | InmobiRovira</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <style>
        body { font-family: 'Plus Jakarta Sans', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif; }
    </style>
</head>
<body x-data="{ mobileMenuOpen: false }" class="min-h-full flex flex-col text-neutral-100 antialiased selection:bg-blue-600 selection:text-white bg-neutral-950">

    {{-- BARRA SUPERIOR EMPRESA (Dark Luxury Glassmorphism) --}}
    <header class="bg-neutral-950/85 backdrop-blur-md border-b border-neutral-800/80 sticky top-0 z-40 shadow-xl">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 h-16 flex items-center justify-between gap-4">

            {{-- Logotipo Oficial InmobiRovira Platino & Badge --}}
            <div class="flex items-center gap-3">
                <a href="{{ route('empresa.index') }}" class="flex items-center gap-2.5 group">
                    <div class="w-9 h-9 rounded-xl bg-neutral-900 border border-neutral-800 shadow-md flex items-center justify-center group-hover:scale-105 transition duration-200">
                        <svg class="w-6 h-6 drop-shadow-md" viewBox="0 0 48 48" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <circle cx="24" cy="24" r="21" stroke="#cbd5e1" stroke-width="2" stroke-dasharray="2 3" />
                            <path d="M13 26L24 16L35 26" stroke="#ffffff" stroke-width="3" stroke-linecap="round" stroke-linejoin="round" />
                            <path d="M17 25V33C17 34.1 17.9 35 19 35H29C30.1 35 31 34.1 31 33V25" stroke="#94a3b8" stroke-width="2.5" stroke-linecap="round" />
                            <path d="M24 35V29" stroke="#ffffff" stroke-width="2.5" stroke-linecap="round" />
                        </svg>
                    </div>
                    <span class="text-xl font-black tracking-tight text-white leading-none">
                        Inmobi<span class="text-slate-300 font-light">rovira</span>
                    </span>
                </a>
                <span class="hidden sm:inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-bold bg-neutral-900 text-neutral-300 border border-neutral-800">
                    <span class="w-2 h-2 rounded-full bg-blue-500 animate-pulse"></span>
                    Portal Empresa
                </span>
            </div>

            {{-- Navegación central para escritorio --}}
            <nav class="hidden md:flex items-center gap-1.5 text-sm font-semibold">
                <a href="{{ route('empresa.index') }}"
                   class="px-4 py-2 rounded-xl transition flex items-center gap-2 {{ request()->routeIs('empresa.index') ? 'bg-neutral-900 text-white font-bold border border-neutral-700 shadow-sm' : 'text-neutral-400 hover:text-white hover:bg-neutral-900/60' }}">
                    <svg class="w-4 h-4 opacity-75" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
                    <span>Mis inmuebles</span>
                </a>

                <a href="{{ route('empresa.crear') }}"
                   class="px-4 py-2 rounded-xl transition flex items-center gap-2 {{ request()->routeIs('empresa.crear') ? 'bg-blue-600 text-white font-bold shadow-lg shadow-blue-600/40 ring-2 ring-blue-400/30' : 'bg-blue-600 hover:bg-blue-500 text-white font-bold shadow-md shadow-blue-600/25' }}">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"/></svg>
                    <span>Publicar inmueble</span>
                </a>

                <a href="{{ route('inicio') }}" target="_blank"
                   class="px-3.5 py-2 rounded-xl text-neutral-400 hover:text-white hover:bg-neutral-900/60 transition flex items-center gap-1.5">
                    <span>Ver portal público</span>
                    <svg class="w-3.5 h-3.5 opacity-70" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/></svg>
                </a>
            </nav>

            {{-- Perfil, Salida y Botón Móvil --}}
            <div class="flex items-center gap-3">
                <div class="hidden sm:flex flex-col text-right leading-tight">
                    <span class="text-xs font-bold text-white truncate max-w-[170px]">
                        {{ auth()->user()?->nombre ?? auth()->user()?->name ?? 'Usuario' }}
                    </span>
                    <span class="text-[11px] text-neutral-400 font-medium truncate max-w-[170px]">
                        {{ auth()->user()?->email ?? '' }}
                    </span>
                </div>

                <form method="POST" action="{{ route('logout') }}" class="hidden sm:block">
                    @csrf
                    <button type="submit"
                            title="Cerrar sesión"
                            class="px-3 py-1.5 rounded-xl text-xs font-bold text-neutral-400 hover:text-rose-400 bg-neutral-900 hover:bg-neutral-800 border border-neutral-800 transition cursor-pointer flex items-center gap-1.5">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/></svg>
                        <span>Salir</span>
                    </button>
                </form>

                {{-- Botón Hamburguesa Móvil --}}
                <button type="button"
                        @click="mobileMenuOpen = !mobileMenuOpen"
                        class="md:hidden p-2 rounded-xl text-neutral-400 hover:text-white hover:bg-neutral-900 border border-neutral-800 focus:outline-none"
                        aria-label="Abrir menú">
                    <svg x-show="!mobileMenuOpen" class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/></svg>
                    <svg x-show="mobileMenuOpen" x-cloak class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                </button>
            </div>
        </div>

        {{-- Menú Desplegable Móvil --}}
        <div x-show="mobileMenuOpen" x-cloak
             x-transition:enter="transition ease-out duration-150"
             x-transition:enter-start="opacity-0 -translate-y-2"
             x-transition:enter-end="opacity-100 translate-y-0"
             x-transition:leave="transition ease-in duration-100"
             x-transition:leave-start="opacity-100 translate-y-0"
             x-transition:leave-end="opacity-0 -translate-y-2"
             class="md:hidden border-t border-neutral-800 bg-neutral-900/95 backdrop-blur-xl px-4 py-4 space-y-2 shadow-2xl">

            <div class="pb-3 mb-2 border-b border-neutral-800">
                <p class="text-xs font-bold text-white">{{ auth()->user()?->nombre ?? auth()->user()?->name ?? 'Usuario' }}</p>
                <p class="text-xs text-neutral-400">{{ auth()->user()?->email ?? '' }}</p>
            </div>

            <a href="{{ route('empresa.index') }}"
               class="flex items-center gap-2.5 px-3 py-2.5 rounded-xl text-sm font-semibold {{ request()->routeIs('empresa.index') ? 'bg-neutral-800 text-white font-bold border border-neutral-700' : 'text-neutral-300 hover:bg-neutral-800' }}">
                <svg class="w-4 h-4 opacity-75" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
                <span>Mis inmuebles</span>
            </a>

            <a href="{{ route('empresa.crear') }}"
               class="flex items-center gap-2.5 px-3 py-2.5 rounded-xl text-sm font-semibold bg-blue-600 text-white font-bold shadow-md">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                <span>Publicar nuevo inmueble</span>
            </a>

            <a href="{{ route('inicio') }}" target="_blank"
               class="flex items-center justify-between px-3 py-2.5 rounded-xl text-sm font-medium text-neutral-300 hover:bg-neutral-800">
                <span>Ver portal público</span>
                <svg class="w-4 h-4 text-neutral-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/></svg>
            </a>

            <form method="POST" action="{{ route('logout') }}" class="pt-2">
                @csrf
                <button type="submit"
                        class="w-full flex items-center justify-center gap-2 px-3 py-2.5 rounded-xl text-xs font-bold text-rose-400 bg-neutral-950 hover:bg-neutral-800 border border-neutral-800 transition">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/></svg>
                    <span>Cerrar sesión</span>
                </button>
            </form>
        </div>
    </header>

    {{-- ALERTAS DE SESIÓN --}}
    <div class="max-w-7xl mx-auto w-full px-4 sm:px-6 lg:px-8 mt-4">
        @if (session('success'))
            <div class="p-4 rounded-2xl bg-emerald-950/70 border border-emerald-800/80 text-emerald-200 text-sm flex items-center justify-between gap-3 shadow-lg">
                <div class="flex items-center gap-2.5">
                    <span class="w-6 h-6 rounded-full bg-emerald-600 text-white flex items-center justify-center shrink-0">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"/></svg>
                    </span>
                    <span class="font-medium">{{ session('success') }}</span>
                </div>
            </div>
        @endif

        @if (session('error'))
            <div class="p-4 rounded-2xl bg-rose-950/70 border border-rose-800/80 text-rose-200 text-sm flex items-center justify-between gap-3 shadow-lg">
                <div class="flex items-center gap-2.5">
                    <span class="w-6 h-6 rounded-full bg-rose-600 text-white flex items-center justify-center shrink-0">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M6 18L18 6M6 6l12 12"/></svg>
                    </span>
                    <span class="font-medium">{{ session('error') }}</span>
                </div>
            </div>
        @endif
    </div>

    {{-- CONTENIDO DINÁMICO --}}
    <main class="flex-1 max-w-7xl mx-auto w-full px-4 sm:px-6 lg:px-8 py-8">
        @yield('content')
    </main>

    {{-- PIE DE PÁGINA --}}
    <footer class="bg-neutral-950 border-t border-neutral-900 py-6 text-center text-xs text-neutral-500">
        <div class="max-w-7xl mx-auto px-4 flex flex-col sm:flex-row items-center justify-between gap-2">
            <span>InmobiRovira &copy; {{ date('Y') }} · Portal para Empresas y Agentes Inmobiliarios</span>
            <span class="text-neutral-600">Provincia de García Rovira, Santander</span>
        </div>
    </footer>

</body>
</html>
