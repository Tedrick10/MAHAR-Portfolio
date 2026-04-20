@php
    $settings = $settings ?? \App\Models\WebsiteSetting::current();
    $telHref = null;
    if (filled($settings->contact_phone)) {
        $telHref = preg_replace('/[^0-9+]/', '', preg_replace('/\s+/', '', $settings->contact_phone));
    }
    $socials = array_filter([
        ['key' => 'facebook', 'url' => $settings->social_facebook, 'label' => 'Facebook'],
        ['key' => 'telegram', 'url' => $settings->social_telegram, 'label' => 'Telegram'],
        ['key' => 'viber', 'url' => $settings->social_viber, 'label' => 'Viber'],
        ['key' => 'tiktok', 'url' => $settings->social_tiktok, 'label' => 'TikTok'],
    ], fn ($s) => filled($s['url']));
@endphp

<footer class="border-t border-zinc-200 bg-zinc-50 text-zinc-700 dark:border-zinc-800/80 dark:bg-zinc-950 dark:text-zinc-300">
    <div class="mx-auto max-w-7xl px-4 py-14 sm:px-6 lg:px-8 lg:py-16">
        <div class="grid grid-cols-1 gap-12 sm:grid-cols-2 lg:grid-cols-4 lg:gap-10">
            {{-- Brand --}}
            <div class="sm:col-span-2 lg:col-span-1">
                <div class="flex items-center gap-2.5">
                    @if ($logoUrl = $settings->logoPublicUrl())
                        <span
                            class="relative h-10 w-10 shrink-0 overflow-hidden rounded-xl bg-white shadow-sm ring-1 ring-zinc-200/80 dark:bg-zinc-900 dark:ring-zinc-700/80"
                        >
                            <img
                                src="{{ $logoUrl }}"
                                alt=""
                                class="h-full w-full object-contain p-1"
                                loading="lazy"
                                decoding="async"
                            />
                        </span>
                    @else
                        <span
                            class="inline-flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-gradient-to-br from-orange-500 to-red-600 text-sm font-bold text-white shadow-lg shadow-orange-500/30"
                            aria-hidden="true"
                        >M</span>
                    @endif
                    <span class="font-display text-lg font-bold uppercase tracking-wide text-zinc-900 dark:text-white">{{ $settings->displayName() }}</span>
                </div>
                <p class="mt-4 max-w-sm text-sm leading-relaxed text-zinc-600 dark:text-zinc-400">
                    {{ $settings->localized('footer_tagline') }}
                </p>
                @if ($socials !== [])
                    <div class="mt-6 flex flex-wrap gap-2.5">
                        @foreach ($socials as $s)
                            <a
                                href="{{ $s['url'] }}"
                                target="_blank"
                                rel="noopener noreferrer"
                                class="flex h-10 w-10 items-center justify-center rounded-full border border-zinc-300 text-zinc-600 transition hover:border-orange-500/60 hover:bg-orange-500/10 hover:text-orange-700 dark:border-zinc-700 dark:text-zinc-300 dark:hover:text-orange-300"
                                aria-label="{{ $s['label'] }}"
                            >
                                <x-footer-social-icon :name="$s['key']" class="h-[1.15rem] w-[1.15rem]" />
                            </a>
                        @endforeach
                    </div>
                @endif
            </div>

            {{-- Services --}}
            <div>
                <h2 class="text-xs font-bold uppercase tracking-[0.2em] text-orange-600 dark:text-orange-400">
                    {{ __('site.footer_services_heading') }}
                </h2>
                <ul class="mt-5 space-y-3 text-sm">
                    <li>
                        <a href="{{ route('portfolio.index') }}" class="text-zinc-700 transition hover:text-orange-600 dark:text-zinc-300 dark:hover:text-orange-300">
                            {{ __('site.footer_link_designs') }}
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('home') }}#design-tools" class="text-zinc-700 transition hover:text-orange-600 dark:text-zinc-300 dark:hover:text-orange-300">
                            {{ __('site.footer_link_tools') }}
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('contact') }}" class="text-zinc-700 transition hover:text-orange-600 dark:text-zinc-300 dark:hover:text-orange-300">
                            {{ __('site.footer_link_collaborate') }}
                        </a>
                    </li>
                </ul>
            </div>

            {{-- Quick links --}}
            <div>
                <h2 class="text-xs font-bold uppercase tracking-[0.2em] text-orange-600 dark:text-orange-400">
                    {{ __('site.footer_quick_heading') }}
                </h2>
                <ul class="mt-5 space-y-3 text-sm">
                    <li>
                        <a href="{{ route('home') }}" class="text-zinc-700 transition hover:text-orange-600 dark:text-zinc-300 dark:hover:text-orange-300">
                            {{ __('site.nav_home') }}
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('home') }}#marketing-services" class="text-zinc-700 transition hover:text-orange-600 dark:text-zinc-300 dark:hover:text-orange-300">
                            {{ __('site.footer_link_services') }}
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('privacy') }}" class="text-zinc-700 transition hover:text-orange-600 dark:text-zinc-300 dark:hover:text-orange-300">
                            {{ __('site.footer_link_privacy') }}
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('terms') }}" class="text-zinc-700 transition hover:text-orange-600 dark:text-zinc-300 dark:hover:text-orange-300">
                            {{ __('site.footer_link_terms') }}
                        </a>
                    </li>
                </ul>
            </div>

            {{-- Contact --}}
            <div class="sm:col-span-2 lg:col-span-1">
                <h2 class="text-xs font-bold uppercase tracking-[0.2em] text-orange-600 dark:text-orange-400">
                    {{ __('site.footer_contact_heading') }}
                </h2>
                <ul class="mt-5 space-y-4 text-sm">
                    @if ($settings->contact_phone)
                        <li class="flex gap-3">
                            <span
                                class="flex h-10 w-10 shrink-0 items-center justify-center rounded-lg bg-orange-50 text-orange-600 ring-1 ring-orange-200 dark:bg-zinc-900 dark:text-orange-400 dark:ring-orange-500/25"
                                aria-hidden="true"
                            >
                                <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <path
                                        d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"
                                    />
                                </svg>
                            </span>
                            <a href="tel:{{ $telHref }}" class="min-w-0 self-center break-all text-zinc-800 transition hover:text-orange-600 dark:text-zinc-200 dark:hover:text-orange-300">
                                {{ $settings->contact_phone }}
                            </a>
                        </li>
                    @endif
                    @if ($settings->contact_email)
                        <li class="flex gap-3">
                            <span
                                class="flex h-10 w-10 shrink-0 items-center justify-center rounded-lg bg-orange-50 text-orange-600 ring-1 ring-orange-200 dark:bg-zinc-900 dark:text-orange-400 dark:ring-orange-500/25"
                                aria-hidden="true"
                            >
                                <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <rect width="20" height="16" x="2" y="4" rx="2" />
                                    <path d="m22 7-8.97 5.7a1.94 1.94 0 0 1-2.06 0L2 7" />
                                </svg>
                            </span>
                            <a href="mailto:{{ $settings->contact_email }}" class="min-w-0 self-center break-all text-zinc-800 transition hover:text-orange-600 dark:text-zinc-200 dark:hover:text-orange-300">
                                {{ $settings->contact_email }}
                            </a>
                        </li>
                    @endif
                    @if ($settings->localized('contact_address'))
                        <li class="flex gap-3">
                            <span
                                class="flex h-10 w-10 shrink-0 items-center justify-center rounded-lg bg-orange-50 text-orange-600 ring-1 ring-orange-200 dark:bg-zinc-900 dark:text-orange-400 dark:ring-orange-500/25"
                                aria-hidden="true"
                            >
                                <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M20 10c0 6-8 12-8 12s-8-6-8-12a8 8 0 0 1 16 0Z" />
                                    <circle cx="12" cy="10" r="3" />
                                </svg>
                            </span>
                            <span class="self-center text-zinc-800 dark:text-zinc-200">
                                {!! nl2br(e($settings->localized('contact_address'))) !!}
                            </span>
                        </li>
                    @endif
                </ul>
            </div>
        </div>
    </div>

    <div class="border-t border-zinc-200 dark:border-zinc-800/90">
        <div class="mx-auto flex max-w-7xl flex-col items-center justify-between gap-3 px-4 py-6 text-xs text-zinc-500 sm:flex-row sm:px-6 lg:px-8">
            <p class="text-center sm:text-left">
                © {{ now()->year }}
                {{ $settings->localized('footer_copyright') ?: $settings->displayName() }}.
                <span class="text-zinc-500 dark:text-zinc-600">{{ __('site.footer_rights') }}</span>
            </p>
            <a
                href="{{ url('/admin') }}"
                class="shrink-0 text-zinc-500 transition hover:text-orange-600 dark:text-zinc-600 dark:hover:text-orange-400"
            >{{ __('site.admin_hint') }}</a>
        </div>
    </div>
</footer>
