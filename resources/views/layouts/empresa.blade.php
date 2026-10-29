<!DOCTYPE html>
<html lang="es" class="h-full bg-slate-50">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Portal Empresa') | InmobiRovira</title>
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
</head>
<body class="min-h-full flex flex-col text-slate-800 antialiased selection:bg-indigo-600 selection:text-white">

    {{-- BARRA SUPERIOR EMPRESA --}}
    <header class="bg-white border-b border-slate-200 sticky top-0 z-40 shadow-xs">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 h-16 flex items-center justify-between gap-4">

            {{-- Logotipo y Badge --}}
            <div class="flex items-center gap-3">
                <a href="{{ route('empresa.index') }}" class="flex items-center gap-2 group">
                    <span class="w-9 h-9 rounded-xl bg-indigo-600 text-white font-black flex items-center justify-center shadow-md shadow-indigo-600/30 group-hover:scale-105 transition">I</span>
                    <span class="text-xl font-black text-slate-900 tracking-tight">Inmobi<span class="text-indigo-600">rovira</span></span>
                </a>
                <span class="hidden sm:inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-bold bg-indigo-50 text-indigo-700 border border-indigo-200">
                    Portal Empresa
                </span>
            </div>

            {{-- Navegación central --}}
            <nav class="hidden md:flex items-center gap-1 text-sm font-semibold">
                <a href="{{ route('empresa.index') }}"
                   class="px-4 py-2 rounded-lg transition {{ request()->routeIs('empresa.index') ? 'bg-indigo-50 text-indigo-700 font-bold' : 'text-slate-600 hover:text-indigo-600 hover:bg-slate-50' }}">
                    Mis inmuebles
                </a>
                <a href="{{ route('empresa.crear') }}"
                   class="px-4 py-2 rounded-lg transition {{ request()->routeIs('empresa.crear') ? 'bg-indigo-50 text-indigo-700 font-bold' : 'text-slate-600 hover:text-indigo-600 hover:bg-slate-50' }}">
                    + Publicar inmueble
                </a>
                <a href="{{ route('inicio') }}" target="_blank"
                   class="px-4 py-2 rounded-lg text-slate-500 hover:text-slate-800 hover:bg-slate-50 flex items-center gap-1">
                    <span>Ver portal público</span>
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/></svg>
                </a>
            </nav>

            {{-- Perfil y Salida --}}
            <div class="flex items-center gap-3">
                <div class="hidden sm:flex flex-col text-right leading-tight">
                    <span class="text-sm font-bold text-slate-900">{{ auth()->user()->nombre ?? auth()->user()->name }}</span>
                    <span class="text-xs text-slate-400 truncate max-w-[180px]">{{ auth()->user()->email }}</span>
                </div>

                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit"
                            title="Cerrar sesión"
                            class="px-3.5 py-2 rounded-lg text-xs sm:text-sm font-semibold text-rose-600 bg-rose-50 hover:bg-rose-100 border border-rose-200 transition cursor-pointer flex items-center gap-1.5">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/></svg>
                        <span class="hidden sm:inline">Cerrar sesión</span>
                    </button>
                </form>
            </div>
        </div>
    </header>

    {{-- ALERTAS DE SESIÓN --}}
    <div class="max-w-7xl mx-auto w-full px-4 sm:px-6 lg:px-8 mt-4">
        @if (session('success'))
            <div class="p-4 rounded-xl bg-emerald-50 border border-emerald-200 text-emerald-800 text-sm flex items-center justify-between gap-3 shadow-xs">
                <div class="flex items-center gap-2">
                    <span class="text-emerald-600 font-bold">✓</span>
                    <span>{{ session('success') }}</span>
                </div>
            </div>
        @endif

        @if (session('error'))
            <div class="p-4 rounded-xl bg-rose-50 border border-rose-200 text-rose-800 text-sm flex items-center justify-between gap-3 shadow-xs">
                <div class="flex items-center gap-2">
                    <span class="text-rose-600 font-bold">✕</span>
                    <span>{{ session('error') }}</span>
                </div>
            </div>
        @endif
    </div>

    {{-- CONTENIDO DINÁMICO --}}
    <main class="flex-1 max-w-7xl mx-auto w-full px-4 sm:px-6 lg:px-8 py-6">
        @yield('content')
    </main>

    {{-- PIE DE PÁGINA --}}
    <footer class="bg-white border-t border-slate-200 py-4 text-center text-xs text-slate-400">
        InmobiRovira &copy; {{ date('Y') }} · Portal para Empresas y Agentes Inmobiliarios
    </footer>

</body>
</html>
