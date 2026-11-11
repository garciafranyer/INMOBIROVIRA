@props([
    'size' => 'md',
    'badge' => null,
    'href' => null,
])

@php
    $iconSize = match($size) {
        'sm' => 'w-7 h-7',
        'lg' => 'w-12 h-12',
        'xl' => 'w-16 h-16',
        default => 'w-10 h-10',
    };

    $containerSize = match($size) {
        'sm' => 'w-8 h-8 rounded-lg',
        'lg' => 'w-14 h-14 rounded-2xl',
        'xl' => 'w-20 h-20 rounded-2xl',
        default => 'w-10 h-10 rounded-xl',
    };

    $textSize = match($size) {
        'sm' => 'text-base',
        'lg' => 'text-2xl',
        'xl' => 'text-3xl',
        default => 'text-xl',
    };

    $url = $href ?? route('inicio');
@endphp

<a href="{{ $url }}" {{ $attributes->merge(['class' => 'inline-flex items-center gap-3 shrink-0 group leading-none']) }}>
    {{-- Isotipo Oficial Platino Perla --}}
    <svg class="{{ $iconSize }} drop-shadow-md shrink-0" viewBox="0 0 48 48" fill="none" xmlns="http://www.w3.org/2000/svg">
        <circle cx="24" cy="24" r="21" stroke="#cbd5e1" stroke-width="2" stroke-dasharray="2 3" />
        <path d="M13 26L24 16L35 26" stroke="#ffffff" stroke-width="3" stroke-linecap="round" stroke-linejoin="round" />
        <path d="M17 25V33C17 34.1 17.9 35 19 35H29C30.1 35 31 34.1 31 33V25" stroke="#94a3b8" stroke-width="2.5" stroke-linecap="round" />
        <path d="M24 35V29" stroke="#ffffff" stroke-width="2.5" stroke-linecap="round" />
    </svg>

    {{-- Texto de Marca Inmobi + rovira --}}
    <div class="leading-none">
        <span class="{{ $textSize }} font-black tracking-tight text-white drop-shadow-md">
            Inmobi<span class="text-slate-300 font-light">rovira</span>
        </span>
        @if ($badge)
            <span class="block text-[10px] font-bold uppercase tracking-wider text-amber-400/90 mt-1 flex items-center gap-1">
                <span class="w-1.5 h-1.5 rounded-full bg-amber-400 animate-pulse"></span>
                {{ $badge }}
            </span>
        @endif
    </div>
</a>
