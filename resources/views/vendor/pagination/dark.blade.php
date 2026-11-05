@if ($paginator->hasPages())
    <nav role="navigation" aria-label="Paginación de propiedades" class="flex flex-col sm:flex-row items-center justify-between gap-4 w-full bg-neutral-900/90 border border-neutral-800 rounded-2xl p-4 shadow-xl">
        {{-- Resumen de conteo --}}
        <div class="text-xs text-neutral-400">
            Mostrando
            <span class="font-bold text-white">{{ $paginator->firstItem() }}</span>
            a
            <span class="font-bold text-white">{{ $paginator->lastItem() }}</span>
            de
            <span class="font-bold text-white">{{ $paginator->total() }}</span>
            propiedades
        </div>

        {{-- Controles de navegación --}}
        <div class="inline-flex items-center gap-1.5 flex-wrap justify-center">
            {{-- Botón Anterior --}}
            @if ($paginator->onFirstPage())
                <span class="inline-flex items-center gap-1 px-3 py-2 text-xs font-semibold text-neutral-500 bg-neutral-950/60 border border-neutral-800/60 rounded-xl cursor-not-allowed">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                    </svg>
                    <span>Anterior</span>
                </span>
            @else
                <a href="{{ $paginator->previousPageUrl() }}" rel="prev" class="inline-flex items-center gap-1 px-3 py-2 text-xs font-semibold text-neutral-200 hover:text-white bg-neutral-950 hover:bg-neutral-800 border border-neutral-700 rounded-xl transition shadow-xs">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                    </svg>
                    <span>Anterior</span>
                </a>
            @endif

            {{-- Números de página --}}
            @foreach ($elements as $element)
                @if (is_string($element))
                    <span class="px-2 text-xs text-neutral-500">{{ $element }}</span>
                @endif

                @if (is_array($element))
                    @foreach ($element as $page => $url)
                        @if ($page == $paginator->currentPage())
                            <span aria-current="page" class="w-8 h-8 flex items-center justify-center text-xs font-bold text-white bg-blue-600 rounded-xl shadow-lg shadow-blue-600/40">
                                {{ $page }}
                            </span>
                        @else
                            <a href="{{ $url }}" class="w-8 h-8 flex items-center justify-center text-xs font-semibold text-neutral-300 hover:text-white bg-neutral-950 hover:bg-neutral-800 border border-neutral-800 rounded-xl transition">
                                {{ $page }}
                            </a>
                        @endif
                    @endforeach
                @endif
            @endforeach

            {{-- Botón Siguiente --}}
            @if ($paginator->hasMorePages())
                <a href="{{ $paginator->nextPageUrl() }}" rel="next" class="inline-flex items-center gap-1 px-3 py-2 text-xs font-semibold text-neutral-200 hover:text-white bg-neutral-950 hover:bg-neutral-800 border border-neutral-700 rounded-xl transition shadow-xs">
                    <span>Siguiente</span>
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                    </svg>
                </a>
            @else
                <span class="inline-flex items-center gap-1 px-3 py-2 text-xs font-semibold text-neutral-500 bg-neutral-950/60 border border-neutral-800/60 rounded-xl cursor-not-allowed">
                    <span>Siguiente</span>
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                    </svg>
                </span>
            @endif
        </div>
    </nav>
@endif
