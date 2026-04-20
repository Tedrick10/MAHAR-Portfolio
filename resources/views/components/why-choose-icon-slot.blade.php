@props([
    'point',
    'index' => 0,
])

@php
    $mediaUrl = $point->iconDisplayUrl();
    $variant = (int) $index % 4;
@endphp

<div class="flex h-12 w-12 shrink-0 items-center justify-center">
    @if ($mediaUrl)
        <span
            class="flex h-12 w-12 items-center justify-center overflow-hidden rounded-xl border border-zinc-200 bg-white shadow-sm dark:border-zinc-700/90 dark:bg-zinc-800/90 dark:shadow-none"
        >
            <img
                src="{{ $mediaUrl }}"
                alt=""
                class="h-7 w-7 object-contain"
                loading="lazy"
                decoding="async"
            />
        </span>
    @elseif (filled($point->icon))
        <span
            class="flex h-12 w-12 items-center justify-center rounded-xl border border-orange-200/90 bg-orange-50 text-2xl text-orange-700 shadow-sm dark:border-orange-500/20 dark:bg-orange-500/10 dark:text-orange-300 dark:shadow-none"
            aria-hidden="true"
        >
            {{ $point->icon }}
        </span>
    @else
        <span
            class="flex h-12 w-12 items-center justify-center rounded-xl border border-orange-200/80 bg-orange-500/[0.09] shadow-sm dark:border-orange-500/15 dark:bg-orange-500/10 dark:shadow-none"
            aria-hidden="true"
        >
            @if ($variant === 0)
                {{-- Sparkle / premium craft --}}
                <svg class="h-7 w-7 text-orange-600 dark:text-orange-400" viewBox="0 0 24 24" fill="none" aria-hidden="true">
                    <path
                        d="M12 2v2.5M12 19.5V22M4.93 4.93l1.77 1.77M17.3 17.3l1.77 1.77M2 12h2.5M19.5 12H22M4.93 19.07l1.77-1.77M17.3 6.7l1.77-1.77"
                        stroke="currentColor"
                        stroke-width="1.5"
                        stroke-linecap="round"
                        opacity="0.55"
                    />
                    <path
                        d="M12 6.5l1.1 3.4h3.6l-2.9 2.1 1.1 3.4L12 15.3l-2.9 2.1 1.1-3.4-2.9-2.1h3.6L12 6.5z"
                        stroke="currentColor"
                        stroke-width="1.5"
                        stroke-linejoin="round"
                    />
                </svg>
            @elseif ($variant === 1)
                {{-- Lightning / speed & systems --}}
                <svg class="h-7 w-7 text-orange-600 dark:text-orange-400" viewBox="0 0 24 24" fill="none" aria-hidden="true">
                    <path
                        d="M13 2L4 14.5h7.5L11 22l9-12.5H12.5L13 2z"
                        stroke="currentColor"
                        stroke-width="1.5"
                        stroke-linejoin="round"
                    />
                </svg>
            @elseif ($variant === 2)
                {{-- Life ring / support & collaboration --}}
                <svg class="h-7 w-7 text-orange-600 dark:text-orange-400" viewBox="0 0 24 24" fill="none" aria-hidden="true">
                    <circle cx="12" cy="12" r="8" stroke="currentColor" stroke-width="1.5" />
                    <circle cx="12" cy="12" r="3.5" stroke="currentColor" stroke-width="1.5" />
                    <path d="M12 4v2M12 18v2M4 12h2M18 12h2" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" opacity="0.4" />
                </svg>
            @else
                {{-- Stack / pricing-style value & handoff --}}
                <svg class="h-7 w-7 text-orange-600 dark:text-orange-400" viewBox="0 0 24 24" fill="none" aria-hidden="true">
                    <path d="M12 4v2M12 18v2M4 12h2M18 12h2" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" opacity="0.35" />
                    <rect x="6" y="5" width="12" height="14" rx="2" stroke="currentColor" stroke-width="1.5" />
                    <path d="M9 12h6M9 16h4" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" opacity="0.85" />
                </svg>
            @endif
        </span>
    @endif
</div>
