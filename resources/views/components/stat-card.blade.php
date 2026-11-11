{{--
    Uso:
    <x-stat-card
        label="Total de usuarios"
        :value="$totalUsers"
        change="+12.4%"
        trend="up"
        icon="users"
    />
    trend: "up" | "down"
--}}
@props(['label', 'value', 'change' => null, 'trend' => 'up', 'icon' => 'chart'])

<div class="bg-white rounded-3xl border border-slate-200/90 shadow-xs hover:shadow-md hover:border-slate-300 transition-all duration-200 p-5 sm:p-6 group">
    <div class="flex items-start justify-between gap-3">
        <div>
            <p class="text-xs font-bold text-slate-400 uppercase tracking-wider">{{ $label }}</p>
            <p class="mt-2 text-3xl font-black text-slate-900 tracking-tight group-hover:text-blue-600 transition">{{ $value }}</p>
        </div>
        <div class="w-12 h-12 rounded-2xl bg-blue-50 text-blue-600 group-hover:bg-blue-600 group-hover:text-white transition flex items-center justify-center shrink-0 shadow-xs">
            <span class="w-6 h-6 block">@include('layouts.partials.icons', ['icon' => $icon])</span>
        </div>
    </div>

    @if ($change)
        <div class="mt-4 pt-3 border-t border-slate-100 flex items-center gap-1.5 text-xs">
            <span class="inline-flex items-center gap-1 font-bold {{ $trend === 'up' ? 'text-emerald-600' : 'text-rose-600' }}">
                @if ($trend === 'up')
                    <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 10l7-7m0 0l7 7m-7-7v18" /></svg>
                @else
                    <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 14l-7 7m0 0l-7-7m7 7V3" /></svg>
                @endif
                {{ $change }}
            </span>
            <span class="text-slate-400">vs. mes anterior</span>
        </div>
    @endif
</div>
