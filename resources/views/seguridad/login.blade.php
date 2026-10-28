<!DOCTYPE html>
<html lang="es" class="h-full bg-slate-950">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Iniciar sesión - {{ config('app.name', 'Inmobirovira') }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Inter', sans-serif; }
    </style>
</head>
<body class="h-full text-slate-100 antialiased bg-gradient-to-b from-slate-900 via-slate-950 to-black">
    <main class="min-h-screen flex flex-col items-center justify-center p-4">
        <div class="w-full max-w-md">

            {{-- Logotipo Superior Oficial Inmobirovira --}}
            <div class="text-center mb-6">
                <a href="{{ route('inicio') }}" class="inline-flex flex-col items-center gap-3 group" title="Ir al inicio de Inmobirovira">
                    <div class="w-16 h-16 rounded-2xl bg-slate-800/80 border border-slate-700/80 shadow-2xl flex items-center justify-center group-hover:scale-105 transition duration-300">
                        <svg class="w-10 h-10 drop-shadow-md" viewBox="0 0 48 48" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <circle cx="24" cy="24" r="21" stroke="#cbd5e1" stroke-width="2" stroke-dasharray="2 3" />
                            <path d="M13 26L24 16L35 26" stroke="#ffffff" stroke-width="3" stroke-linecap="round" stroke-linejoin="round" />
                            <path d="M17 25V33C17 34.1 17.9 35 19 35H29C30.1 35 31 34.1 31 33V25" stroke="#94a3b8" stroke-width="2.5" stroke-linecap="round" />
                            <path d="M24 35V29" stroke="#ffffff" stroke-width="2.5" stroke-linecap="round" />
                        </svg>
                    </div>
                    <div class="leading-none">
                        <span class="text-3xl font-black tracking-tight text-white">Inmobi<span class="text-blue-500 font-light">rovira</span></span>
                    </div>
                </a>
                <p class="text-xs text-slate-400 mt-2 font-medium tracking-wide">
                    Panel de Administración y Control
                </p>
            </div>

            {{-- Tarjeta del Formulario --}}
            <div class="bg-slate-900/90 rounded-2xl border border-slate-800 shadow-2xl backdrop-blur-xl p-6 sm:p-8">
                <h2 class="text-lg font-bold text-white mb-1">Iniciar sesión</h2>
                <p class="text-xs text-slate-400 mb-6">Ingresa tus credenciales para acceder al sistema</p>

                <form action="{{ route('login.store') }}" method="POST" class="space-y-4">
                    @csrf

                    <div>
                        <label for="email" class="block text-xs font-semibold uppercase tracking-wider text-slate-300 mb-1.5">
                            Correo electrónico
                        </label>
                        <input type="email" name="email" id="email" value="{{ old('email') }}" required autofocus autocomplete="email"
                               class="w-full rounded-xl bg-slate-950/80 border border-slate-700/80 text-white placeholder-slate-500 shadow-sm focus:border-blue-500 focus:ring-2 focus:ring-blue-500/30 px-3.5 py-2.5 text-sm transition @error('email') border-red-500 @enderror">
                        @error('email')
                            <p class="mt-1.5 text-xs text-red-400 font-medium">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="password" class="block text-xs font-semibold uppercase tracking-wider text-slate-300 mb-1.5">
                            Contraseña
                        </label>
                        <input type="password" name="password" id="password" required autocomplete="current-password"
                               placeholder="••••••••"
                               class="w-full rounded-xl bg-slate-950/80 border border-slate-700/80 text-white placeholder-slate-500 shadow-sm focus:border-blue-500 focus:ring-2 focus:ring-blue-500/30 px-3.5 py-2.5 text-sm transition @error('password') border-red-500 @enderror">
                        @error('password')
                            <p class="mt-1.5 text-xs text-red-400 font-medium">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="flex items-center justify-between text-xs pt-1">
                        <label class="flex items-center gap-2 text-slate-300 cursor-pointer select-none">
                            <input type="checkbox" name="remember" value="1" class="rounded bg-slate-950 border-slate-700 text-blue-600 focus:ring-0 focus:ring-offset-0 h-4 w-4">
                            <span>Recordarme</span>
                        </label>
                    </div>

                    <button type="submit"
                            class="w-full mt-2 rounded-xl bg-blue-600 hover:bg-blue-500 text-white font-bold py-2.5 shadow-lg shadow-blue-600/30 transition transform hover:scale-[1.01] active:scale-[0.99] cursor-pointer">
                        Ingresar al Panel
                    </button>
                </form>
            </div>

            {{-- Enlace Volver al Sitio Web --}}
            <div class="text-center mt-6">
                <a href="{{ route('inicio') }}" class="text-xs text-slate-400 hover:text-white transition inline-flex items-center gap-1.5 font-medium">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                    </svg>
                    <span>Volver al sitio web</span>
                </a>
            </div>

        </div>
    </main>
</body>
</html>
