<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Inmobirovira') | Inmobirovira</title>
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
</head>
<body class="bg-gray-50 text-gray-800 min-h-screen flex flex-col">

    {{-- ENCABEZADO --}}
    <header class="bg-white border-b border-gray-200 shadow-sm sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-4 py-4 flex items-center justify-between">

            <a href="{{ route('inicio') }}" class="flex items-center gap-2">
                <span class="w-8 h-9 rounded-lg bg-indigo-600 text-white font-bold flex items-center justify-center">I</span>
                <span class="text-xl font-bold text-gray-800">nmobirovira</span>
            </a>

            {{-- Menú escritorio --}}
            <nav class="hidden md:flex items-center gap-8 text-sm font-medium">
                <a href="{{ route('inicio') }}"
                class="{{ request()->routeIs('inicio') ? 'text-indigo-600' : 'text-gray-600 hover:text-indigo-600' }} transition">
                    Inicio
                </a>
                <a href="{{ route('inicio') }}#inmuebles" class="text-gray-600 hover:text-indigo-600 transition">
                    Inmuebles
                </a>
                <a href="#contacto" class="text-gray-600 hover:text-indigo-600 transition">
                    Contacto
                </a>
            </nav>

            {{-- Menú celular  --}}
            <details class="md:hidden relative">
                <summary class="list-none cursor-pointer p-2 rounded-lg border border-gray-300 text-gray-600">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" class="w-6 h-6">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                    </svg>
                </summary>

                <nav class="absolute right-0 top-full mt-2 w-48 bg-white border border-gray-200 rounded-lg shadow-lg p-3 space-y-2 text-sm font-medium">
                    <a href="{{ route('inicio') }}" class="block py-2 text-gray-700 hover:text-indigo-600">Inicio</a>
                    <a href="{{ route('inicio') }}#inmuebles" class="block py-2 text-gray-700 hover:text-indigo-600">Inmuebles</a>
                    <a href="#contacto" class="block py-2 text-gray-700 hover:text-indigo-600">Contacto</a>
                </nav>
            </details>
        </div>
    </header>

    {{-- MENSAJES --}}
    @if (session('success'))
        <div class="max-w-7xl mx-auto w-full px-4 mt-6">
            <div class="bg-green-50 border border-green-300 text-green-700 px-4 py-3 rounded-lg">
                {{ session('success') }}
            </div>
        </div>
    @endif

    {{-- CONTENIDO --}}
    <main class="flex-1 max-w-7xl mx-auto w-full px-4 py-8">
        @yield('content')
    </main>

    {{-- PIE DE PÁGINA --}}
    <footer id="contacto" class="bg-gray-900 text-gray-300 mt-10">
        <div class="max-w-7xl mx-auto px-4 py-10 grid grid-cols-1 md:grid-cols-3 gap-8">

            <div>
                <h3 class="text-white font-bold text-lg mb-3">Inmobirovira</h3>
                <p class="text-sm text-gray-400">
                    Encuentra casas, apartamentos y locales en venta y arriendo en la provincia de García Rovira, Santander.
                </p>
            </div>

            <div>
                <h3 class="text-white font-semibold mb-3">Enlaces</h3>
                <ul class="space-y-2 text-sm">
                    <li><a href="{{ route('inicio') }}" class="hover:text-white transition">Inicio</a></li>
                    <li><a href="{{ route('inicio') }}#inmuebles" class="hover:text-white transition">Inmuebles disponibles</a></li>
                </ul>
            </div>

            <div>
                <h3 class="text-white font-semibold mb-3">Contacto</h3>
                <ul class="space-y-2 text-sm text-gray-400">
                    <li>Málaga, Santander</li>
                    <li>correo@ejemplo.com</li>
                    <li>+57 300 000 0000</li>
                </ul>
            </div>

        </div>

        <div class="border-t border-gray-800">
            <div class="max-w-7xl mx-auto px-4 py-4 text-center text-xs text-gray-500">
                © {{ date('Y') }} Inmobirovira. Todos los derechos reservados.
            </div>
        </div>
    </footer>

</body>
</html>