@extends('layouts.public')

@section('title', $item->localized('title').' — '.\App\Models\WebsiteSetting::current()->displayName())

@section('content')
    <article class="mx-auto max-w-7xl px-4 py-8 sm:px-6 sm:py-10 lg:px-8">
        <a
            href="{{ route('portfolio.index') }}"
            class="inline-flex text-sm font-semibold text-orange-600 transition hover:underline dark:text-orange-400"
        >← {{ __('site.portfolio_meta') }}</a>

        @if ($detailMedia !== [])
            <div class="mx-auto mt-6 w-full">
                <div class="portfolio-detail-gallery">
                    @foreach ($detailMedia as $block)
                        @if (($block['kind'] ?? '') === 'image')
                            <button
                                type="button"
                                class="portfolio-detail-gallery__cell group cursor-zoom-in rounded-xl border border-zinc-200 bg-zinc-100 p-0 shadow-sm ring-0 transition hover:ring-2 hover:ring-orange-500/40 focus:outline-none focus-visible:ring-2 focus-visible:ring-orange-500 dark:border-zinc-800 dark:bg-zinc-900 dark:hover:ring-orange-400/35"
                                @click="$dispatch('image-zoom', { src: @js($block['url']), alt: @js($item->localized('title')) })"
                                aria-label="{{ __('site.zoom_image') }}"
                            >
                                <img
                                    src="{{ $block['url'] }}"
                                    alt=""
                                    width="800"
                                    height="600"
                                    decoding="async"
                                    class="transition duration-500 ease-out group-hover:scale-[1.04] motion-reduce:group-hover:scale-100"
                                >
                            </button>
                        @elseif (($block['kind'] ?? '') === 'youtube')
                            {{-- Direct iframe embed (same pattern as typical school / gallery sites). Do not use this.$root for IDs — it is unreliable in inline Alpine. --}}
                            <div
                                class="portfolio-detail-gallery__cell portfolio-detail-gallery__cell--embed overflow-hidden rounded-xl border border-zinc-200 bg-zinc-900 shadow-sm dark:border-zinc-800"
                            >
                                <iframe
                                    class="absolute inset-0 z-0 h-full w-full border-0"
                                    src="https://www.youtube.com/embed/{{ $block['video_id'] }}?rel=0&modestbranding=1&playsinline=1"
                                    title="YouTube — {{ $item->localized('title') }}"
                                    allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
                                    referrerpolicy="strict-origin-when-cross-origin"
                                    allowfullscreen
                                    loading="lazy"
                                ></iframe>
                            </div>
                        @elseif (($block['kind'] ?? '') === 'video')
                            <div class="portfolio-detail-gallery__cell portfolio-detail-gallery__cell--embed rounded-xl border border-zinc-200 bg-black shadow-sm dark:border-zinc-800">
                                <video
                                    class="h-full w-full object-contain"
                                    controls
                                    playsinline
                                    preload="metadata"
                                    src="{{ $block['url'] }}"
                                ></video>
                            </div>
                        @endif
                    @endforeach
                </div>
            </div>
        @endif
    </article>
@endsection
