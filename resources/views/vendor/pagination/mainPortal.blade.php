@if ($paginator->hasPages())
    <div class="flex justify-center items-center gap-2 mt-8">

        {{-- Previous Page Link --}}
        @if ($paginator->onFirstPage())
            <button
                class="w-8 h-8 flex items-center justify-center rounded-full border border-color shadow-custom-combo sub-text text-gray-400 cursor-not-allowed"
                disabled>
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="none" stroke="currentColor"
                    viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                </svg>
            </button>
        @else
            <a href="{{ $paginator->previousPageUrl() }}"
                class="w-8 h-8 flex items-center justify-center rounded-full border border-color shadow-custom-combo sub-text hover:bg-[#7790c2] text-black hover:text-white">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="none"
                    stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                </svg>
            </a>
        @endif

        {{-- Pagination Elements --}}
        @foreach ($elements as $element)
            {{-- "Three Dots" Separator --}}
            @if (is_string($element))
                <span class="sub-text">{{ $element }}</span>
            @endif

            {{-- Array of Links --}}
            @if (is_array($element))
                @foreach ($element as $page => $url)
                    @if ($page == $paginator->currentPage())
                        <span
                            class="w-8 h-8 flex items-center justify-center rounded-full bg-[#4490D9] text-white font-medium text-sm">
                            {{ $page }}
                        </span>
                    @else
                        <a href="{{ $url }}"
                            class="w-8 h-8 flex items-center justify-center rounded-full sub-text hover:bg-[#e3e8f3] font-medium text-sm">
                            {{ $page }}
                        </a>
                    @endif
                @endforeach
            @endif
        @endforeach

        {{-- Next Page Link --}}
        @if ($paginator->hasMorePages())
            <a href="{{ $paginator->nextPageUrl() }}"
                class="w-8 h-8 flex items-center justify-center rounded-full border border-color shadow-custom-combo sub-text hover:bg-[#7790c2] text-black hover:text-white">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="none"
                    stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                </svg>
            </a>
        @else
            <button
                class="w-8 h-8 flex items-center justify-center rounded-full border border-color shadow-custom-combo sub-text text-gray-400 cursor-not-allowed"
                disabled>
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="none"
                    stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                </svg>
            </button>
        @endif
    </div>
@endif
