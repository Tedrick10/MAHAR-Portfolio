@props([
    'marketingServices' => null,
])

@php
    /** @var callable(array|string): string $t */
    $loc = app()->getLocale();
    $t = function ($v) use ($loc) {
        if (is_array($v)) {
            return $v[$loc] ?? $v['en'] ?? '';
        }

        return (string) $v;
    };
    /** @var array<string, mixed> $m */
    $m = is_array($marketingServices) ? $marketingServices : config('marketing_services');
    $fb = $m['facebook'];
    $tt = $m['tiktok'];
@endphp

<section
    id="marketing-services"
    class="services-marketing-surface relative scroll-mt-24 overflow-hidden"
    aria-labelledby="marketing-services-title"
>
    <div class="pointer-events-none absolute inset-0 overflow-hidden" aria-hidden="true">
        <div
            class="absolute -right-24 top-0 h-72 w-72 rounded-full bg-orange-400/30 blur-[100px] motion-reduce:blur-none dark:bg-orange-600/20"
        ></div>
        <div
            class="absolute -left-20 bottom-0 h-80 w-80 rounded-full bg-rose-300/25 blur-[110px] motion-reduce:blur-none dark:bg-red-600/15"
        ></div>
    </div>

    <div
        class="services-marketing-grain pointer-events-none absolute inset-0 opacity-[0.04] dark:opacity-[0.055]"
        aria-hidden="true"
    ></div>

    <div class="relative mx-auto max-w-7xl px-4 py-16 sm:px-6 sm:py-20 lg:px-8 lg:py-24">
        <p class="text-center text-xs font-bold uppercase tracking-[0.35em] text-orange-600 dark:text-orange-400">
            {{ __('site.services_lab_kicker') }}
        </p>
        <h2
            id="marketing-services-title"
            class="services-font-display mt-3 text-center text-3xl font-bold tracking-tight text-zinc-900 sm:text-4xl dark:text-white"
        >
            {{ __('site.services_heading') }}
        </h2>
        <p class="mx-auto mt-3 max-w-2xl text-center text-sm leading-relaxed text-zinc-600 sm:text-base dark:text-zinc-400">
            {{ __('site.services_intro') }}
        </p>

        <div class="mt-10 flex flex-wrap items-center justify-center gap-2">
            <a
                href="#facebook-services"
                class="rounded-full border border-zinc-300/90 bg-white/90 px-4 py-2 text-xs font-semibold uppercase tracking-wider text-zinc-700 shadow-sm backdrop-blur transition hover:border-orange-400/80 hover:bg-orange-50 hover:text-zinc-900 dark:border-white/10 dark:bg-white/5 dark:text-zinc-200 dark:shadow-none dark:hover:border-orange-500/50 dark:hover:bg-orange-500/10 dark:hover:text-white"
            >Facebook</a>
            <a
                href="#tiktok-services"
                class="rounded-full border border-zinc-300/90 bg-white/90 px-4 py-2 text-xs font-semibold uppercase tracking-wider text-zinc-700 shadow-sm backdrop-blur transition hover:border-orange-400/80 hover:bg-orange-50 hover:text-zinc-900 dark:border-white/10 dark:bg-white/5 dark:text-zinc-200 dark:shadow-none dark:hover:border-orange-500/50 dark:hover:bg-orange-500/10 dark:hover:text-white"
            >TikTok</a>
            <a
                href="{{ route('contact') }}"
                class="rounded-full bg-gradient-to-r from-orange-500 to-red-600 px-4 py-2 text-xs font-semibold uppercase tracking-wider text-white shadow-lg shadow-orange-300/40 transition hover:brightness-110 dark:shadow-orange-900/40"
            >{{ __('site.services_cta_contact') }}</a>
        </div>

        {{-- Facebook --}}
        <div id="facebook-services" class="mt-16 scroll-mt-28">
            <div class="flex flex-col items-center text-center">
                <p class="text-sm font-medium text-zinc-500 dark:text-zinc-500">{{ __('site.services_facebook_kicker') }}</p>
                <h3 class="mt-1 font-mono text-xl font-semibold tracking-wide text-zinc-900 sm:text-2xl dark:text-white">
                    {{ __('site.services_facebook_title') }}
                </h3>
            </div>

            <p class="mx-auto mt-10 max-w-xl text-center text-xs font-bold uppercase tracking-[0.25em] text-orange-600 dark:text-orange-400">
                {{ __('site.services_fb_branding_heading') }}
            </p>
            <div class="mt-6 grid gap-6 lg:grid-cols-3">
                @foreach ($fb['branding'] as $pkg)
                    <div
                        class="flex flex-col rounded-2xl border border-zinc-200/90 bg-white/90 p-6 shadow-lg shadow-zinc-900/5 backdrop-blur-sm dark:border-white/10 dark:bg-zinc-900/60 dark:shadow-xl dark:shadow-black/40 dark:backdrop-blur-md"
                    >
                        <div class="text-center">
                            <p class="services-font-display text-2xl font-bold tracking-[0.12em] text-zinc-900 sm:text-3xl dark:text-white">
                                {{ $t($pkg['tier']) }}
                            </p>
                            <p class="services-font-script -mt-1 text-2xl text-orange-600 sm:text-[1.65rem] dark:text-orange-400">
                                {{ __('site.services_package_script') }}
                            </p>
                        </div>
                        <ul class="mt-6 space-y-2 border-t border-zinc-200/80 pt-5 text-left text-sm text-zinc-600 dark:border-white/10 dark:text-zinc-300">
                            <li class="flex justify-between gap-3 border-b border-zinc-100 py-1.5 font-mono text-xs text-zinc-500 dark:border-white/5 dark:text-zinc-400">
                                <span>{{ $t($pkg['option']) }}</span>
                            </li>
                            <li class="flex justify-between gap-3 border-b border-zinc-100 py-1.5 font-mono text-xs text-zinc-500 dark:border-white/5 dark:text-zinc-400">
                                <span>{{ $t($pkg['revision']) }}</span>
                            </li>
                            @foreach ($pkg['items'] as $item)
                                <li class="flex gap-2.5">
                                    <span class="mt-1.5 h-1.5 w-1.5 shrink-0 rounded-full bg-orange-500 dark:bg-orange-500" aria-hidden="true"></span>
                                    <span>{{ $t($item) }}</span>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                @endforeach
            </div>

            <p class="mx-auto mt-14 max-w-xl text-center text-xs font-bold uppercase tracking-[0.25em] text-orange-600 dark:text-orange-400">
                {{ __('site.services_fb_monthly_heading') }}
            </p>
            <div class="mt-6 grid gap-6 lg:grid-cols-3">
                @foreach ($fb['monthly'] as $col)
                    <div
                        class="flex flex-col rounded-2xl border border-zinc-200/90 bg-white/95 p-6 shadow-md shadow-zinc-900/5 backdrop-blur-sm dark:border-white/10 dark:bg-black/30 dark:shadow-none"
                    >
                        <div class="border-b border-zinc-200/90 pb-4 text-center dark:border-white/10">
                            <h4 class="text-lg font-semibold text-zinc-900 dark:text-white">{{ $t($col['name']) }}</h4>
                            <p class="mt-2 font-mono text-2xl font-bold text-orange-600 dark:text-orange-400">
                                {{ $col['price'] }}
                                <span class="text-sm font-semibold text-zinc-500">{{ $col['currency'] }}</span>
                            </p>
                        </div>
                        <ul class="mt-4 flex flex-1 flex-col gap-2.5 text-sm text-zinc-600 dark:text-zinc-300">
                            @foreach ($col['features'] as $feat)
                                <li class="flex gap-2">
                                    <span class="mt-1.5 h-1.5 w-1.5 shrink-0 rounded-full bg-orange-500 dark:bg-orange-500/90" aria-hidden="true"></span>
                                    <span>{{ $t($feat) }}</span>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                @endforeach
            </div>
        </div>

        {{-- TikTok --}}
        <div id="tiktok-services" class="mt-20 scroll-mt-28">
            <div class="flex flex-col items-center text-center">
                <p class="text-sm font-medium text-zinc-500">{{ __('site.services_tiktok_kicker') }}</p>
                <h3 class="mt-1 font-mono text-xl font-semibold tracking-wide text-zinc-900 sm:text-2xl dark:text-white">
                    {{ __('site.services_tiktok_title') }}
                </h3>
                <p class="mt-2 max-w-2xl text-sm text-zinc-600 dark:text-zinc-400">{{ __('site.services_tiktok_subtitle') }}</p>
            </div>

            <div class="mt-8 overflow-x-auto rounded-2xl border border-zinc-200/90 bg-white/95 shadow-xl shadow-zinc-900/10 dark:border-white/10 dark:bg-zinc-950/50 dark:shadow-2xl dark:shadow-black/50">
                <table class="w-full min-w-[720px] border-collapse text-left text-sm text-zinc-700 dark:text-zinc-300">
                    <caption class="sr-only">
                        {{ __('site.services_tiktok_title') }}
                    </caption>
                    <thead>
                        <tr class="border-b border-zinc-200 bg-zinc-100/95 dark:border-white/10 dark:bg-black/40">
                            <th scope="col" class="px-4 py-3 font-semibold text-zinc-500 dark:text-zinc-400">
                                {{ __('site.services_tiktok_col_detail') }}
                            </th>
                            @foreach ($tt['plan_labels'] as $plan)
                                <th scope="col" class="px-3 py-3 text-center font-semibold text-zinc-900 dark:text-white">{{ $t($plan) }}</th>
                            @endforeach
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($tt['rows'] as $row)
                            <tr class="border-b border-zinc-100 hover:bg-orange-50/60 dark:border-white/5 dark:hover:bg-white/[0.02]">
                                <td class="px-4 py-3 align-top text-zinc-500 dark:text-zinc-400">{{ $t($row['label']) }}</td>
                                @foreach ($row['cells'] as $cell)
                                    <td class="px-3 py-3 text-center align-top text-zinc-800 dark:text-zinc-200">
                                        @if ($cell === 'yes')
                                            <span class="text-emerald-600 dark:text-emerald-400" aria-label="Yes">✓</span>
                                        @elseif ($cell === 'no')
                                            <span class="text-zinc-300 dark:text-zinc-600" aria-label="No">—</span>
                                        @else
                                            {{ $t($cell) }}
                                        @endif
                                    </td>
                                @endforeach
                            </tr>
                        @endforeach
                        <tr class="border-b border-orange-200/80 bg-orange-100/90 font-mono text-xs dark:border-white/10 dark:bg-orange-950/20">
                            <td class="px-4 py-3 font-semibold text-orange-800 dark:text-orange-300">
                                {{ __('site.services_tiktok_row_per_video') }}
                            </td>
                            @foreach ($tt['per_video'] as $pv)
                                <td class="px-3 py-3 text-center text-orange-900 dark:text-orange-200">{{ $pv }}</td>
                            @endforeach
                        </tr>
                        <tr class="bg-orange-200/50 font-mono text-sm font-semibold dark:bg-orange-950/30">
                            <td class="px-4 py-3 text-orange-950 dark:text-orange-100">{{ __('site.services_tiktok_row_total') }}</td>
                            @foreach ($tt['totals'] as $tot)
                                <td class="px-3 py-3 text-center text-zinc-900 dark:text-white">{{ $tot }}</td>
                            @endforeach
                        </tr>
                    </tbody>
                </table>
            </div>

            <p class="mt-4 text-center text-xs text-zinc-500 dark:text-zinc-500">{{ $t($tt['footnote']) }}</p>

            <div class="mt-8 flex flex-wrap items-center justify-center gap-4">
                <a
                    href="{{ asset('files/tiktok-marketing-plan.pdf') }}"
                    class="inline-flex items-center gap-2 rounded-full border border-zinc-300/90 bg-zinc-50 px-5 py-2.5 text-sm font-semibold text-zinc-800 shadow-sm transition hover:border-orange-400/80 hover:bg-orange-50 hover:text-zinc-900 dark:border-white/15 dark:bg-white/5 dark:text-white dark:shadow-none dark:hover:border-orange-500/40 dark:hover:bg-orange-500/10"
                    download
                >
                    <span aria-hidden="true">↓</span>
                    {{ __('site.services_download_pdf') }}
                </a>
            </div>
        </div>
    </div>
</section>
