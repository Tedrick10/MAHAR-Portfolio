@extends('layouts.public')

@section('title', $item->localized('title').' — '.\App\Models\WebsiteSetting::current()->displayName())

@section('content')
    <article class="mx-auto max-w-7xl px-4 py-8 sm:px-6 sm:py-10 lg:px-8">
        <a
            href="{{ route('portfolio.index') }}"
            class="inline-flex text-sm font-semibold text-orange-600 transition hover:underline dark:text-orange-400"
        >← {{ __('site.portfolio_meta') }}</a>

        @if ($galleryUrls !== [])
            <div class="mx-auto mt-6 w-full">
                <div class="portfolio-detail-gallery">
                    @foreach ($galleryUrls as $url)
                        <button
                            type="button"
                            class="portfolio-detail-gallery__cell group cursor-zoom-in rounded-xl border border-zinc-200 bg-zinc-100 p-0 shadow-sm ring-0 transition hover:ring-2 hover:ring-orange-500/40 focus:outline-none focus-visible:ring-2 focus-visible:ring-orange-500 dark:border-zinc-800 dark:bg-zinc-900 dark:hover:ring-orange-400/35"
                            @click="$dispatch('image-zoom', { src: @js($url), alt: @js($item->localized('title')) })"
                            aria-label="{{ __('site.zoom_image') }}"
                        >
                            <img
                                src="{{ $url }}"
                                alt=""
                                width="800"
                                height="600"
                                decoding="async"
                                class="transition duration-500 ease-out group-hover:scale-[1.04] motion-reduce:group-hover:scale-100"
                            >
                        </button>
                    @endforeach
                </div>
            </div>
        @endif
    </article>
@endsection
