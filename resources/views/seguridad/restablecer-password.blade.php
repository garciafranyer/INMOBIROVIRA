<!DOCTYPE html>
<html lang="es" class="h-full bg-slate-950">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Restablecer contraseña - {{ config('app.name', 'Inmobirovira') }}</title>
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
                        <span class="text-3xl font-black tracking-tight text-white">Inmobi<span class="text-slate-300 font-light">rovira</span></span>
                    </div>
                </a>
                <p class="text-xs text-slate-400 mt-2 font-medium tracking-wide">
                    Establecer Nueva Contraseña
                </p>
            </div>

            {{-- Tarjeta del Formulario --}}
            <div class="bg-slate-900/90 rounded-2xl border border-slate-800 shadow-2xl backdrop-blur-xl p-6 sm:p-8">
                <div class="flex items-center gap-2 mb-2">
                    <span class="text-xl">🔑</span>
                    <h2 class="text-lg font-bold text-white">Crea tu nueva contraseña</h2>
                </div>
                <p class="text-xs text-slate-400 mb-5 leading-relaxed">
                    Ingresa y confirma tu nueva contraseña de acceso. Asegúrate de que tenga al menos 8 caracteres.
                </p>

                <form action="{{ route('password.update') }}" method="POST" class="space-y-4">
                    @csrf
                    <input type="hidden" name="token" value="{{ $token }}">

                    <div>
                        <label for="email" class="block text-xs font-semibold uppercase tracking-wider text-slate-300 mb-1.5">
                            Correo electrónico
                        </label>
                        <input type="email" name="email" id="email" value="{{ old('email', $email) }}" required autocomplete="email"
                               class="w-full rounded-xl bg-slate-950/80 border border-slate-700/80 text-white placeholder-slate-500 shadow-sm focus:border-blue-500 focus:ring-2 focus:ring-blue-500/30 px-3.5 py-2.5 text-sm transition @error('email') border-red-500 @enderror">
                        @error('email')
                            <p class="mt-1.5 text-xs text-red-400 font-medium">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="password" class="block text-xs font-semibold uppercase tracking-wider text-slate-300 mb-1.5">
                            Nueva contraseña
                        </label>
                        <input type="password" name="password" id="password" required autocomplete="new-password"
                               placeholder="Mínimo 8 caracteres"
                               class="w-full rounded-xl bg-slate-950/80 border border-slate-700/80 text-white placeholder-slate-500 shadow-sm focus:border-blue-500 focus:ring-2 focus:ring-blue-500/30 px-3.5 py-2.5 text-sm transition @error('password') border-red-500 @enderror">
                        @error('password')
                            <p class="mt-1.5 text-xs text-red-400 font-medium">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="password_confirmation" class="block text-xs font-semibold uppercase tracking-wider text-slate-300 mb-1.5">
                            Confirmar nueva contraseña
                        </label>
                        <input type="password" name="password_confirmation" id="password_confirmation" required autocomplete="new-password"
                               placeholder="Repite tu nueva contraseña"
                               class="w-full rounded-xl bg-slate-950/80 border border-slate-700/80 text-white placeholder-slate-500 shadow-sm focus:border-blue-500 focus:ring-2 focus:ring-blue-500/30 px-3.5 py-2.5 text-sm transition">
                    </div>

                    <button type="submit"
                            class="w-full mt-2 rounded-xl bg-blue-600 hover:bg-blue-500 text-white font-bold py-2.5 shadow-lg shadow-blue-600/30 transition transform hover:scale-[1.01] active:scale-[0.99] cursor-pointer">
                        Restablecer y Guardar Contraseña
                    </button>
                </form>

                <div class="mt-6 pt-5 border-t border-slate-800 text-center">
                    <a href="{{ route('login') }}" class="inline-flex items-center gap-1.5 text-xs text-slate-400 hover:text-white transition">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
                        <span>Cancelar y volver al inicio de sesión</span>
                    </a>
                </div>
            </div>

            {{-- Enlace Volver al Sitio Web --}}
            <div class="text-center mt-6">
                <a href="{{ route('inicio') }}" class="text-xs text-slate-400 hover:text-white transition inline-flex items-center gap-1">
                    <span>&larr; Volver al sitio web</span>
                </a>
            </div>

        </div>
    </main>
</body>
</html>
