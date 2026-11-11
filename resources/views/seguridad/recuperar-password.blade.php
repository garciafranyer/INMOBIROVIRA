<!DOCTYPE html>
<html lang="es" class="h-full bg-slate-950">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Recuperar contraseña - {{ config('app.name', 'Inmobirovira') }}</title>
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
                    Recuperación de Acceso
                </p>
            </div>

            {{-- Tarjeta del Formulario --}}
            <div class="bg-slate-900/90 rounded-2xl border border-slate-800 shadow-2xl backdrop-blur-xl p-6 sm:p-8">
                <div class="flex items-center gap-2 mb-2">
                    <span class="text-xl">🔐</span>
                    <h2 class="text-lg font-bold text-white">¿Olvidaste tu contraseña?</h2>
                </div>
                <p class="text-xs text-slate-400 mb-5 leading-relaxed">
                    No te preocupes. Ingresa tu correo electrónico registrado y te enviaremos un enlace seguro para restablecerla.
                </p>

                {{-- Alerta de Éxito --}}
                @if (session('status'))
                    <div class="mb-5 p-3.5 rounded-xl bg-emerald-950/60 border border-emerald-800/80 text-xs text-emerald-200 leading-relaxed flex items-start gap-2.5">
                        <svg class="w-5 h-5 text-emerald-400 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        <div>
                            <strong class="text-white block font-semibold mb-0.5">Enlace enviado</strong>
                            <span>{{ session('status') }}</span>
                        </div>
                    </div>
                @endif

                <form action="{{ route('password.email') }}" method="POST" class="space-y-4">
                    @csrf

                    <div>
                        <label for="email" class="block text-xs font-semibold uppercase tracking-wider text-slate-300 mb-1.5">
                            Correo electrónico registrado
                        </label>
                        <input type="email" name="email" id="email" value="{{ old('email') }}" required autofocus autocomplete="email"
                               placeholder="ejemplo@inmobirovira.com"
                               class="w-full rounded-xl bg-slate-950/80 border border-slate-700/80 text-white placeholder-slate-500 shadow-sm focus:border-blue-500 focus:ring-2 focus:ring-blue-500/30 px-3.5 py-2.5 text-sm transition @error('email') border-red-500 @enderror">
                        @error('email')
                            <p class="mt-1.5 text-xs text-red-400 font-medium">{{ $message }}</p>
                        @enderror
                    </div>

                    <button type="submit"
                            class="w-full mt-2 rounded-xl bg-blue-600 hover:bg-blue-500 text-white font-bold py-2.5 shadow-lg shadow-blue-600/30 transition transform hover:scale-[1.01] active:scale-[0.99] cursor-pointer">
                        Enviar enlace de recuperación
                    </button>
                </form>

                <div class="mt-6 pt-5 border-t border-slate-800 text-center">
                    <a href="{{ route('login') }}" class="inline-flex items-center gap-1.5 text-xs text-slate-400 hover:text-white transition">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
                        <span>Volver a Iniciar sesión</span>
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
