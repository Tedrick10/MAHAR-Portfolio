@extends('layouts.public')

@section('title', __('site.portfolio_meta').' — '.\App\Models\WebsiteSetting::current()->displayName())

@section('content')
    <div class="relative overflow-hidden border-b border-zinc-200 bg-white dark:border-zinc-800 dark:bg-zinc-950">
        <div class="pointer-events-none absolute inset-0 bg-[radial-gradient(ellipse_at_top_right,rgba(139,92,246,0.12),transparent_50%)] dark:bg-[radial-gradient(ellipse_at_top_right,rgba(139,92,246,0.18),transparent_45%)]"></div>
        <div class="relative mx-auto max-w-6xl px-4 py-16 sm:px-6 lg:px-8">
            <h1 class="animate-fade-up text-4xl font-semibold tracking-tight text-zinc-900 dark:text-white sm:text-5xl">
                {{ $settings->localized('portfolio_heading') }}
            </h1>
            <p class="animate-fade-up mt-4 max-w-2xl text-lg text-zinc-600 dark:text-zinc-400" style="animation-delay: 80ms">
                {{ $settings->localized('portfolio_intro') }}
            </p>
        </div>
    </div>

    <div class="mx-auto max-w-6xl px-4 py-16 sm:px-6 lg:px-8">
        <div class="columns-1 gap-6 space-y-6 sm:columns-2 lg:columns-3">
            @foreach ($items as $index => $item)
                @php
                    $img = $item->coverImageUrl();
                @endphp
                <article
                    class="card-reveal group break-inside-avoid overflow-hidden rounded-2xl border border-zinc-200 bg-white shadow-sm transition hover:border-orange-300/60 hover:shadow-lg hover:shadow-orange-500/10 dark:border-zinc-800 dark:bg-zinc-900 dark:hover:border-orange-500/30"
                    x-intersect.once="$el.classList.add('animate-fade-up')"
                    style="animation-delay: {{ min($index * 70, 420) }}ms"
                >
                    <div class="relative overflow-hidden bg-zinc-100 dark:bg-zinc-800">
                        @if ($img)
                            <div class="relative aspect-[3/4] cursor-zoom-in overflow-hidden" role="presentation">
                                <img
                                    src="{{ $img }}"
                                    alt=""
                                    class="h-full w-full object-cover transition duration-700 ease-out group-hover:scale-110 motion-reduce:group-hover:scale-100"
                                >
                                <button
                                    type="button"
                                    class="absolute inset-0 z-10 flex items-end justify-end p-3"
                                    @click="$dispatch('image-zoom', { src: @js($img), alt: @js($item->localized('title')) })"
                                    aria-label="{{ __('site.zoom_image') }}"
                                >
                                    <span class="flex h-10 w-10 items-center justify-center rounded-full bg-black/45 text-lg text-white shadow-lg backdrop-blur-sm transition hover:scale-110 hover:bg-black/60">⌕</span>
                                </button>
                            </div>
                        @else
                            <div
                                class="flex aspect-[3/4] items-center justify-center bg-gradient-to-br from-orange-500/25 to-red-500/15 text-3xl font-semibold text-zinc-400"
                            >{{ $item->localized('title') }}</div>
                        @endif
                    </div>
                    <div class="p-5">
                        @if ($item->localized('category'))
                            <p class="text-xs font-bold uppercase tracking-wider text-orange-600 dark:text-orange-400">
                                {{ $item->localized('category') }}
                            </p>
                        @endif
                        <h2 class="mt-2 text-xl font-semibold text-zinc-900 dark:text-white">
                            <a href="{{ route('portfolio.show', $item->slug) }}" class="transition hover:text-orange-600 dark:hover:text-orange-400">
                                {{ $item->localized('title') }}
                            </a>
                        </h2>
                        @if ($item->localized('summary'))
                            <p class="mt-2 line-clamp-3 text-sm text-zinc-600 dark:text-zinc-400">{{ $item->localized('summary') }}</p>
                        @endif
                        <a
                            href="{{ route('portfolio.show', $item->slug) }}"
                            class="mt-3 inline-block text-sm font-semibold text-orange-600 underline-offset-4 hover:underline dark:text-orange-400"
                        >{{ __('site.cta_all_designs') }} →</a>
                    </div>
                </article>
            @endforeach
        </div>
    </div>
@endsection
