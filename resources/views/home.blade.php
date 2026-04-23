@extends('layouts.public')

@section('title', \App\Models\WebsiteSetting::current()->displayName())

@section('content')
    <section class="relative overflow-hidden border-b border-zinc-200 dark:border-zinc-800">
        <div
            class="pointer-events-none absolute -left-32 top-0 h-96 w-96 animate-orb-slow rounded-full bg-orange-500/20 blur-3xl dark:bg-orange-600/20"
            aria-hidden="true"
        ></div>
        <div
            class="pointer-events-none absolute -right-24 bottom-0 h-80 w-80 animate-orb-slow rounded-full bg-red-500/15 blur-3xl motion-reduce:animate-none dark:bg-red-500/10"
            style="animation-delay: -4s"
            aria-hidden="true"
        ></div>

        <div
            class="relative mx-auto grid max-w-7xl items-center gap-12 px-4 pb-20 pt-16 sm:px-6 sm:pt-24 lg:grid-cols-[minmax(0,1.14fr)_minmax(0,0.86fr)] lg:gap-x-14 lg:gap-y-10 lg:px-8 lg:pt-28"
        >
            <div class="min-w-0">
                @if ($settings->localized('hero_kicker'))
                    <p
                        @class([
                            'animate-fade-up text-orange-600 dark:text-orange-400',
                            'text-xs font-bold uppercase tracking-[0.25em]' => app()->getLocale() !== 'my',
                            'text-sm font-semibold tracking-wide normal-case' => app()->getLocale() === 'my',
                        ])
                        style="animation-delay: 40ms"
                    >{{ $settings->localized('hero_kicker') }}</p>
                @endif
                <h1
                    class="animate-fade-up mt-4 max-w-none text-balance font-display text-4xl font-semibold leading-snug tracking-normal text-zinc-900 dark:text-white sm:text-5xl sm:leading-snug lg:text-6xl lg:leading-[1.28] xl:text-7xl xl:leading-[1.22]"
                    style="animation-delay: 120ms"
                >
                    {{ $settings->localized('hero_title') }}
                </h1>
                <p
                    class="animate-fade-up mt-6 max-w-2xl text-lg leading-relaxed text-zinc-600 dark:text-zinc-400 lg:max-w-2xl xl:max-w-3xl"
                    style="animation-delay: 200ms"
                >{{ $settings->localized('hero_subtitle') }}</p>
                @php
                    $heroPrimaryUrlFilled = filled(trim((string) ($settings->hero_cta_primary_url ?? '')));
                    $heroPrimaryHref = $heroPrimaryUrlFilled ? $settings->hero_cta_primary_url : route('cv.download');
                    $heroPrimaryIsCvDownload = ! $heroPrimaryUrlFilled;
                @endphp
                <div class="animate-fade-up mt-10 flex flex-wrap gap-3" style="animation-delay: 280ms">
                    <a
                        href="{{ $heroPrimaryHref }}"
                        @if ($heroPrimaryIsCvDownload) download="{{ $settings->cvDownloadBaseName() }}" @endif
                        class="btn-shine inline-flex items-center justify-center rounded-full bg-zinc-900 px-6 py-3 text-sm font-semibold text-white shadow-lg shadow-zinc-900/20 transition hover:-translate-y-0.5 hover:bg-zinc-800 dark:bg-white dark:text-zinc-900 dark:shadow-none dark:hover:bg-zinc-200"
                    >{{ $settings->localized('hero_cta_primary_label') ?: __('site.cta_download_cv') }}</a>
                    @if ($settings->hero_cta_secondary_url)
                        <a
                            href="{{ $settings->hero_cta_secondary_url }}"
                            class="inline-flex items-center justify-center rounded-full border border-zinc-300 bg-white/60 px-6 py-3 text-sm font-semibold text-zinc-800 backdrop-blur transition hover:-translate-y-0.5 dark:border-zinc-600 dark:bg-zinc-900/60 dark:text-zinc-100"
                        >{{ $settings->localized('hero_cta_secondary_label') ?: __('site.cta_start_design') }}</a>
                    @else
                        <a
                            href="{{ route('contact') }}"
                            class="inline-flex items-center justify-center rounded-full border border-zinc-300 bg-white/60 px-6 py-3 text-sm font-semibold text-zinc-800 backdrop-blur transition hover:-translate-y-0.5 dark:border-zinc-600 dark:bg-zinc-900/60 dark:text-zinc-100"
                        >{{ $settings->localized('hero_cta_secondary_label') ?: __('site.cta_start_design') }}</a>
                    @endif
                </div>
            </div>

            <div
                class="animate-fade-up relative mx-auto w-full max-w-md lg:mx-0 lg:max-w-none lg:justify-self-end"
                style="animation-delay: 160ms"
            >
                @php
                    $heroImages = method_exists($settings, 'heroImageUrls')
                        ? $settings->heroImageUrls(4)
                        : [$settings->heroImageUrl()];
                    if ($heroImages === []) {
                        $heroImages = [asset('images/hero-designer.jpg')];
                    }
                @endphp
                <div
                    class="pointer-events-none absolute -inset-3 -z-10 rounded-[2rem] bg-gradient-to-br from-orange-400/25 via-red-400/15 to-transparent blur-2xl dark:from-orange-500/20 dark:via-red-500/10"
                    aria-hidden="true"
                ></div>
                <div class="mx-auto w-full max-w-[560px]">
                    <div class="grid grid-cols-2 gap-3 lg:gap-4" style="display:grid;grid-template-columns:repeat(2,minmax(0,1fr));gap:0.75rem;">
                    @foreach ($heroImages as $heroIndex => $heroImage)
                        <figure
                            class="relative m-0 aspect-square min-w-0 overflow-hidden rounded-2xl bg-zinc-100 shadow-xl shadow-zinc-900/10 ring-1 ring-zinc-200/80 dark:bg-zinc-800 dark:shadow-black/40 dark:ring-zinc-600/60"
                            style="position:relative;margin:0;aspect-ratio:1 / 1;overflow:hidden;"
                        >
                            <img
                                src="{{ $heroImage }}"
                                alt="{{ __('site.hero_designer_alt') }}"
                                class="h-full w-full object-cover object-center transition duration-300"
                                width="560"
                                height="560"
                                @if ($heroIndex === 0) fetchpriority="high" @endif
                                decoding="async"
                            >
                        </figure>
                    @endforeach
                    </div>
                </div>
            </div>
        </div>
    </section>

    <x-services-marketing :marketing-services="$settings->marketingServicesResolved()" />

    <section class="relative mx-auto max-w-6xl px-4 py-20 sm:px-6 lg:px-8">
        <div class="absolute left-1/2 top-0 h-px w-32 -translate-x-1/2 bg-gradient-to-r from-transparent via-orange-500 to-transparent opacity-80"></div>

        <div class="flex flex-col gap-4 md:flex-row md:items-end md:justify-between">
            <div class="animate-fade-up">
                <h2 class="text-2xl font-semibold tracking-tight text-zinc-900 dark:text-white md:text-3xl">
                    {{ $settings->localized('portfolio_heading') }}
                </h2>
                <p class="mt-2 max-w-2xl text-zinc-600 dark:text-zinc-400">
                    {{ $settings->localized('portfolio_intro') }}
                </p>
            </div>
            <a
                href="{{ route('portfolio.index') }}"
                class="animate-fade-up inline-flex items-center gap-1 text-sm font-semibold text-orange-600 transition hover:gap-2 hover:underline dark:text-orange-400"
                style="animation-delay: 80ms"
            >
                {{ __('site.cta_all_designs') }} →
            </a>
        </div>

        <div class="mt-12 grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
            @foreach ($featured as $index => $item)
                @php
                    $img = $item->coverImageUrl();
                @endphp
                <article
                    class="card-reveal group flex flex-col overflow-hidden rounded-2xl border border-zinc-200 bg-white shadow-sm ring-0 transition hover:ring-2 hover:ring-orange-500/30 dark:border-zinc-800 dark:bg-zinc-900 dark:hover:ring-orange-400/25"
                    x-intersect.once="$el.classList.add('animate-fade-up')"
                    style="animation-delay: {{ min($index * 90, 400) }}ms"
                >
                    <div class="relative aspect-[4/5] overflow-hidden bg-zinc-100 dark:bg-zinc-800">
                        @if ($img)
                            <img
                                src="{{ $img }}"
                                alt=""
                                class="h-full w-full object-cover transition duration-700 ease-out group-hover:scale-110 motion-reduce:group-hover:scale-100"
                            >
                            <div
                                class="pointer-events-none absolute inset-0 bg-gradient-to-t from-zinc-950/70 via-transparent to-orange-500/5 opacity-60 transition duration-500 group-hover:opacity-90"
                            ></div>
                            <button
                                type="button"
                                class="absolute right-3 top-3 z-20 flex h-10 w-10 items-center justify-center rounded-full bg-black/40 text-lg text-white shadow-lg backdrop-blur-sm transition hover:scale-110 hover:bg-black/55 focus:outline-none focus-visible:ring-2 focus-visible:ring-white"
                                @click.stop="$dispatch('image-zoom', { src: @js($img), alt: @js($item->localized('title')) })"
                                aria-label="{{ __('site.zoom_image') }}"
                            >⌕</button>
                        @else
                            <div
                                class="flex h-full w-full items-center justify-center bg-gradient-to-br from-orange-500/30 to-red-500/20 text-4xl font-bold text-white/80"
                            >+</div>
                        @endif
                    </div>
                    <div class="flex flex-1 flex-col p-5">
                        @if ($item->localized('category'))
                            <p class="text-xs font-bold uppercase tracking-wider text-orange-600 dark:text-orange-400">{{ $item->localized('category') }}</p>
                        @endif
                        <h3 class="mt-1 text-lg font-semibold text-zinc-900 dark:text-white">{{ $item->localized('title') }}</h3>
                        <a
                            href="{{ route('portfolio.show', $item->slug) }}"
                            class="mt-4 inline-flex text-sm font-semibold text-zinc-600 underline-offset-4 transition hover:text-orange-600 hover:underline dark:text-zinc-400 dark:hover:text-orange-400"
                        >{{ __('site.portfolio_meta') }} →</a>
                    </div>
                </article>
            @endforeach
        </div>
    </section>

    @if ($whyChoosePoints->isNotEmpty())
        <section
            id="why-choose-us"
            class="scroll-mt-24 border-t border-zinc-200 bg-gradient-to-b from-zinc-50 to-white py-20 dark:border-zinc-800 dark:from-zinc-950 dark:to-zinc-950 sm:py-24"
        >
            <div class="mx-auto max-w-6xl px-4 sm:px-6 lg:px-8">
                <div class="max-w-2xl">
                    <p class="text-[11px] font-semibold uppercase tracking-[0.22em] text-orange-600 dark:text-orange-400">
                        {{ __('site.why_choose_kicker') }}
                    </p>
                    <h2 class="mt-3 font-display text-3xl font-semibold tracking-tight text-zinc-900 sm:text-[2rem] dark:text-white">
                        {{ __('site.why_choose_heading') }}
                    </h2>
                    <p class="mt-4 max-w-xl text-[15px] leading-relaxed text-zinc-600 dark:text-zinc-400">
                        {{ __('site.why_choose_intro') }}
                    </p>
                </div>
                <div class="mt-14 grid gap-6 sm:grid-cols-2 lg:mt-16 lg:grid-cols-4 lg:gap-6">
                    @foreach ($whyChoosePoints as $wi => $point)
                        <div
                            class="group flex flex-col items-center rounded-2xl border border-zinc-200/90 bg-white p-8 text-center shadow-[0_1px_3px_rgba(0,0,0,0.06)] transition duration-300 hover:-translate-y-0.5 hover:border-zinc-300 hover:shadow-[0_12px_40px_-24px_rgba(0,0,0,0.18)] dark:border-zinc-800 dark:bg-zinc-900 dark:shadow-lg dark:shadow-black/25 dark:hover:border-zinc-700 dark:hover:shadow-xl dark:hover:shadow-black/30"
                            x-intersect.once="$el.classList.add('animate-fade-up')"
                            style="animation-delay: {{ min($wi * 70, 350) }}ms"
                        >
                            <x-why-choose-icon-slot :point="$point" :index="$wi" />
                            <h3 class="mt-6 text-lg font-semibold tracking-tight text-zinc-900 dark:text-white">
                                {{ $point->localized('title') }}
                            </h3>
                            <p class="mt-3 text-sm leading-relaxed text-zinc-600 dark:text-zinc-400">
                                {{ $point->localized('body') }}
                            </p>
                        </div>
                    @endforeach
                </div>
            </div>
        </section>
    @endif

    @if ($designTools->isNotEmpty())
        <section id="design-tools" class="scroll-mt-24 border-t border-zinc-200 bg-gradient-to-b from-zinc-50 to-white py-20 dark:border-zinc-800 dark:from-zinc-950 dark:to-zinc-900">
            <div class="mx-auto max-w-6xl px-4 sm:px-6 lg:px-8">
                <div class="max-w-2xl">
                    <p class="text-xs font-bold uppercase tracking-[0.2em] text-orange-600 dark:text-orange-400">{{ __('site.tools_kicker') }}</p>
                    <h2 class="mt-3 text-3xl font-semibold tracking-tight text-zinc-900 dark:text-white">
                        {{ __('site.tools_heading') }}
                    </h2>
                    <p class="mt-3 text-zinc-600 dark:text-zinc-400">
                        {{ __('site.tools_intro') }}
                    </p>
                </div>

                <div class="mt-12 grid gap-4 sm:grid-cols-2 lg:grid-cols-3">
                    @foreach ($designTools as $ti => $tool)
                        @php
                            $logo = $tool->logoImageUrl();
                        @endphp
                        <div
                            class="tool-card group relative flex items-center gap-4 rounded-2xl border border-zinc-200 bg-white/90 p-4 shadow-sm transition hover:border-orange-500/50 hover:shadow-lg hover:shadow-orange-500/25 dark:border-zinc-700 dark:bg-zinc-900/80 dark:hover:border-orange-400/50 dark:hover:shadow-orange-500/20"
                            x-intersect.once="$el.classList.add('animate-fade-up')"
                            style="animation-delay: {{ min($ti * 60, 360) }}ms"
                        >
                            <div class="flex h-16 w-16 shrink-0 items-center justify-center overflow-hidden rounded-xl bg-white shadow-sm ring-1 ring-zinc-200/90 dark:bg-zinc-50 dark:ring-zinc-500/40">
                                @if ($logo)
                                    <img src="{{ $logo }}" alt="" class="h-12 w-12 object-contain transition duration-300 group-hover:scale-110">
                                @else
                                    <span class="text-lg font-bold text-orange-600 dark:text-orange-400">{{ \Illuminate\Support\Str::substr($tool->localized('name'), 0, 1) }}</span>
                                @endif
                            </div>
                            <div class="min-w-0 flex-1">
                                @if ($tool->localized('category'))
                                    <p class="text-[11px] font-semibold uppercase tracking-wider text-orange-600 dark:text-orange-400">{{ $tool->localized('category') }}</p>
                                @endif
                                @if ($tool->website_url)
                                    <a
                                        href="{{ $tool->website_url }}"
                                        target="_blank"
                                        rel="noopener noreferrer"
                                        class="block truncate text-base font-semibold text-zinc-900 underline-offset-2 transition hover:text-orange-600 hover:underline dark:text-white dark:hover:text-orange-400"
                                    >{{ $tool->localized('name') }}</a>
                                    <p class="mt-0.5 text-xs text-zinc-500 dark:text-zinc-400">{{ __('site.tools_visit') }} →</p>
                                @else
                                    <p class="truncate text-base font-semibold text-zinc-900 dark:text-white">{{ $tool->localized('name') }}</p>
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </section>
    @endif

    @if ($customerReviews->isNotEmpty())
        <section id="reviews" class="scroll-mt-24 border-t border-zinc-200 bg-gradient-to-b from-zinc-100 to-zinc-50 py-16 dark:border-zinc-800 dark:from-zinc-900 dark:to-zinc-950 sm:py-20">
            <div class="mx-auto max-w-6xl px-4 text-center sm:px-6 lg:px-8">
                <p class="text-xs font-bold uppercase tracking-[0.2em] text-orange-600 dark:text-orange-400">{{ __('site.reviews_kicker') }}</p>
                <h2 class="mt-3 text-3xl font-semibold tracking-tight text-zinc-900 dark:text-white md:text-4xl">
                    {{ __('site.reviews_heading') }}
                </h2>
                <p class="mx-auto mt-3 max-w-2xl text-sm text-zinc-600 md:text-base dark:text-zinc-400">
                    {{ __('site.reviews_intro') }}
                </p>
            </div>

            <div class="review-marquee-mask relative mx-auto mt-10 max-w-6xl overflow-hidden px-4 sm:px-6 lg:px-8">
                <div class="review-marquee-track flex w-max items-stretch gap-5 md:gap-6">
                    @foreach ($customerReviews as $review)
                        <article class="review-marquee-item flex w-[min(100vw-3rem,22rem)] shrink-0 flex-col rounded-2xl border border-zinc-200 bg-white p-6 shadow-sm dark:border-zinc-700 dark:bg-zinc-900">
                            <div class="flex gap-0.5 text-orange-400" aria-hidden="true">
                                @for ($s = 1; $s <= 5; $s++)
                                    <span class="{{ $s <= $review->rating ? 'opacity-100' : 'opacity-25' }}">★</span>
                                @endfor
                            </div>
                            <p class="mt-4 flex-1 text-sm leading-relaxed text-zinc-700 dark:text-zinc-300">
                                “{{ $review->localized('body') }}”
                            </p>
                            <footer class="mt-5 border-t border-zinc-100 pt-4 dark:border-zinc-800">
                                <p class="font-semibold text-zinc-900 dark:text-white">{{ $review->localized('author') }}</p>
                                @if ($review->localized('role'))
                                    <p class="mt-0.5 text-xs text-zinc-500 dark:text-zinc-400">{{ $review->localized('role') }}</p>
                                @endif
                            </footer>
                        </article>
                    @endforeach
                    @foreach ($customerReviews as $review)
                        <article class="review-marquee-item flex w-[min(100vw-3rem,22rem)] shrink-0 flex-col rounded-2xl border border-zinc-200 bg-white p-6 shadow-sm dark:border-zinc-700 dark:bg-zinc-900" aria-hidden="true">
                            <div class="flex gap-0.5 text-orange-400" aria-hidden="true">
                                @for ($s = 1; $s <= 5; $s++)
                                    <span class="{{ $s <= $review->rating ? 'opacity-100' : 'opacity-25' }}">★</span>
                                @endfor
                            </div>
                            <p class="mt-4 flex-1 text-sm leading-relaxed text-zinc-700 dark:text-zinc-300">
                                “{{ $review->localized('body') }}”
                            </p>
                            <footer class="mt-5 border-t border-zinc-100 pt-4 dark:border-zinc-800">
                                <p class="font-semibold text-zinc-900 dark:text-white">{{ $review->localized('author') }}</p>
                                @if ($review->localized('role'))
                                    <p class="mt-0.5 text-xs text-zinc-500 dark:text-zinc-400">{{ $review->localized('role') }}</p>
                                @endif
                            </footer>
                        </article>
                    @endforeach
                </div>
            </div>
        </section>
    @endif

    @if ($partners->isNotEmpty())
        <section id="partnerships" class="scroll-mt-24 border-t border-zinc-200 bg-gradient-to-b from-zinc-50 via-white to-zinc-100 py-16 text-zinc-900 dark:border-zinc-800 dark:from-zinc-950 dark:via-zinc-900 dark:to-zinc-950 dark:text-white">
            <div class="mx-auto max-w-6xl px-4 text-center sm:px-6 lg:px-8">
                <p class="text-xs font-bold uppercase tracking-[0.2em] text-orange-600 dark:text-orange-400">{{ __('site.partnerships_kicker') }}</p>
                <h2 class="mt-3 text-3xl font-semibold tracking-tight md:text-4xl">
                    {{ $settings->localized('partnership_heading') }}
                </h2>
            </div>

            <div class="partner-marquee-mask relative mx-auto mt-10 max-w-6xl overflow-hidden px-4 sm:px-6 lg:px-8">
                <div class="partner-marquee-track flex w-max items-center gap-8 md:gap-12">
                    @foreach ($partners as $partner)
                        @php($plogo = $partner->logoImageUrl())
                        @if ($partner->website_url)
                            <a
                                href="{{ $partner->website_url }}"
                                target="_blank"
                                rel="noopener noreferrer"
                                class="partner-marquee-item flex shrink-0 items-center px-2 py-1 transition hover:opacity-90 dark:hover:opacity-90"
                            >
                                @if ($plogo)
                                    <img src="{{ $plogo }}" alt="{{ $partner->localized('name') }}" class="h-16 w-auto max-w-[260px] object-contain md:h-24 md:max-w-[340px]">
                                @else
                                    <span class="text-sm font-semibold text-zinc-800 dark:text-white/90">{{ $partner->localized('name') }}</span>
                                @endif
                            </a>
                        @else
                            <div class="partner-marquee-item flex shrink-0 items-center px-2 py-1">
                                @if ($plogo)
                                    <img src="{{ $plogo }}" alt="" class="h-16 w-auto max-w-[260px] object-contain md:h-24 md:max-w-[340px]">
                                @else
                                    <span class="text-sm font-semibold text-zinc-800 dark:text-white/90">{{ $partner->localized('name') }}</span>
                                @endif
                            </div>
                        @endif
                    @endforeach
                    @foreach ($partners as $partner)
                        @php($plogo = $partner->logoImageUrl())
                        <div
                            class="partner-marquee-item flex shrink-0 items-center px-2 py-1"
                            aria-hidden="true"
                        >
                            @if ($plogo)
                                <img src="{{ $plogo }}" alt="" class="h-16 w-auto max-w-[260px] object-contain md:h-24 md:max-w-[340px]">
                            @else
                                <span class="text-sm font-semibold text-zinc-700 dark:text-white/80">{{ $partner->localized('name') }}</span>
                            @endif
                        </div>
                    @endforeach
                </div>
            </div>
        </section>
    @endif

    @if ($faqs->isNotEmpty())
        <section id="faq" class="scroll-mt-24 border-t border-zinc-200 bg-gradient-to-b from-white to-zinc-50 py-16 dark:border-zinc-800 dark:from-zinc-950 dark:to-zinc-900">
            <div class="mx-auto max-w-6xl px-4 sm:px-6 lg:px-8">
                <div class="max-w-2xl">
                    <p class="text-xs font-bold uppercase tracking-[0.2em] text-orange-600 dark:text-orange-400">{{ __('site.faq_kicker') }}</p>
                    <h2 class="mt-3 text-3xl font-semibold tracking-tight text-zinc-900 dark:text-white">
                        {{ $settings->localized('faq_heading') }}
                    </h2>
                    @if ($settings->localized('faq_intro'))
                        <p class="mt-3 text-zinc-600 dark:text-zinc-400">
                            {{ $settings->localized('faq_intro') }}
                        </p>
                    @endif
                </div>

                <div class="mt-10 grid grid-cols-1 gap-6 sm:grid-cols-2 sm:gap-8" x-data="{ open: null }">
                    @foreach ($faqs->take(10)->values()->chunk(5) as $columnFaqs)
                        <div class="flex min-w-0 flex-col gap-3">
                            @foreach ($columnFaqs as $faq)
                                <div class="overflow-hidden rounded-2xl border border-zinc-200 bg-white dark:border-zinc-800 dark:bg-zinc-900">
                                    <button
                                        type="button"
                                        class="flex w-full items-center justify-between gap-4 px-5 py-4 text-left text-sm font-semibold text-zinc-900 dark:text-white"
                                        @click="open === {{ $faq->id }} ? open = null : open = {{ $faq->id }}"
                                        :aria-expanded="(open === {{ $faq->id }}).toString()"
                                    >
                                        <span class="min-w-0 pr-2">{{ $faq->localized('question') }}</span>
                                        <span class="shrink-0 text-orange-600 dark:text-orange-400" x-text="open === {{ $faq->id }} ? '−' : '+'"></span>
                                    </button>
                                    <div
                                        x-show="open === {{ $faq->id }}"
                                        x-transition
                                        x-cloak
                                        class="border-t border-zinc-100 px-5 py-4 text-sm leading-relaxed text-zinc-600 dark:border-zinc-800 dark:text-zinc-300"
                                    >
                                        {{ $faq->localized('answer') }}
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @endforeach
                </div>
            </div>
        </section>
    @endif
@endsection
