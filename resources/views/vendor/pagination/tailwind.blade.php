@if ($paginator->hasPages())
<nav role="navigation" aria-label="Pagination Navigation" class="flex items-center justify-between gap-4">

    <!-- Mobile Simple -->
    <div class="flex flex-1 justify-between sm:hidden">
        @if ($paginator->onFirstPage())
            <span class="inline-flex items-center gap-1.5 px-4 py-2 rounded-xl text-sm font-bold bg-slate-100 text-slate-400 cursor-default">← Sebelumnya</span>
        @else
            <a href="{{ $paginator->previousPageUrl() }}" class="inline-flex items-center gap-1.5 px-4 py-2 rounded-xl text-sm font-bold bg-white border border-slate-200 text-slate-700 hover:bg-slate-50 hover:shadow-sm transition">← Sebelumnya</a>
        @endif

        @if ($paginator->hasMorePages())
            <a href="{{ $paginator->nextPageUrl() }}" class="inline-flex items-center gap-1.5 px-4 py-2 rounded-xl text-sm font-bold bg-white border border-slate-200 text-slate-700 hover:bg-slate-50 hover:shadow-sm transition">Berikutnya →</a>
        @else
            <span class="inline-flex items-center gap-1.5 px-4 py-2 rounded-xl text-sm font-bold bg-slate-100 text-slate-400 cursor-default">Berikutnya →</span>
        @endif
    </div>

    <!-- Desktop Full -->
    <div class="hidden sm:flex sm:flex-1 sm:items-center sm:justify-between">
        <div>
            <p class="text-xs text-slate-500 font-semibold">
                Menampilkan
                <span class="font-extrabold text-slate-700">{{ $paginator->firstItem() }}</span>
                –
                <span class="font-extrabold text-slate-700">{{ $paginator->lastItem() }}</span>
                dari
                <span class="font-extrabold text-slate-700">{{ $paginator->total() }}</span>
                data
            </p>
        </div>

        <div>
            <span class="relative z-0 inline-flex items-center gap-1 rounded-2xl">

                {{-- Previous Button --}}
                @if ($paginator->onFirstPage())
                    <span aria-disabled="true" class="inline-flex items-center justify-center w-9 h-9 rounded-xl text-sm font-bold text-slate-300 bg-slate-50 border border-slate-100 cursor-not-allowed">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15 19l-7-7 7-7"/></svg>
                    </span>
                @else
                    <a href="{{ $paginator->previousPageUrl() }}" rel="prev"
                        class="inline-flex items-center justify-center w-9 h-9 rounded-xl text-sm font-bold text-slate-600 bg-white border border-slate-200 hover:bg-slate-50 hover:border-brand-accent hover:text-brand-900 transition shadow-sm">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15 19l-7-7 7-7"/></svg>
                    </a>
                @endif

                {{-- Page Numbers --}}
                @foreach ($elements as $element)
                    @if (is_string($element))
                        <span class="inline-flex items-center justify-center w-9 h-9 rounded-xl text-sm font-bold text-slate-400">…</span>
                    @endif

                    @if (is_array($element))
                        @foreach ($element as $page => $url)
                            @if ($page == $paginator->currentPage())
                                <span aria-current="page"
                                    class="inline-flex items-center justify-center w-9 h-9 rounded-xl text-sm font-extrabold text-brand-900 bg-brand-accent border border-brand-accent shadow-md shadow-amber-200 scale-105">
                                    {{ $page }}
                                </span>
                            @else
                                <a href="{{ $url }}"
                                    class="inline-flex items-center justify-center w-9 h-9 rounded-xl text-sm font-bold text-slate-600 bg-white border border-slate-200 hover:bg-slate-50 hover:border-brand-accent hover:text-brand-900 transition shadow-sm">
                                    {{ $page }}
                                </a>
                            @endif
                        @endforeach
                    @endif
                @endforeach

                {{-- Next Button --}}
                @if ($paginator->hasMorePages())
                    <a href="{{ $paginator->nextPageUrl() }}" rel="next"
                        class="inline-flex items-center justify-center w-9 h-9 rounded-xl text-sm font-bold text-slate-600 bg-white border border-slate-200 hover:bg-slate-50 hover:border-brand-accent hover:text-brand-900 transition shadow-sm">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7"/></svg>
                    </a>
                @else
                    <span aria-disabled="true" class="inline-flex items-center justify-center w-9 h-9 rounded-xl text-sm font-bold text-slate-300 bg-slate-50 border border-slate-100 cursor-not-allowed">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7"/></svg>
                    </span>
                @endif

            </span>
        </div>
    </div>
</nav>
@endif
