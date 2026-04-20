@php
    /** @var \App\Models\WebsiteSetting $settings */
    $settings = $settings ?? \App\Models\WebsiteSetting::current();
@endphp

<header
    class="sticky top-0 z-50 border-b border-zinc-200/80 bg-white/80 backdrop-blur-md dark:border-zinc-800/80 dark:bg-zinc-950/80"
>
    <div class="mx-auto flex max-w-6xl items-center justify-between gap-4 px-4 py-4 sm:px-6 lg:px-8">
        <a href="{{ route('home') }}" class="group flex items-center gap-2.5">
            @if ($logoUrl = $settings->logoPublicUrl())
                <span
                    class="relative h-9 w-9 shrink-0 overflow-hidden rounded-xl bg-white shadow-sm ring-1 ring-zinc-200/80 dark:bg-zinc-900 dark:ring-zinc-700/80"
                >
                    <img
                        src="{{ $logoUrl }}"
                        alt=""
                        class="h-full w-full object-contain p-1 transition group-hover:scale-105"
                        loading="eager"
                        decoding="async"
                    />
                </span>
            @else
                <span
                    class="inline-flex h-9 w-9 shrink-0 items-center justify-center rounded-xl bg-gradient-to-br from-orange-500 to-red-600 text-sm font-bold text-white shadow-lg shadow-orange-500/30 transition group-hover:scale-105"
                    aria-hidden="true"
                >M</span>
            @endif
            <span class="text-lg font-semibold tracking-tight text-zinc-900 dark:text-white">{{ $settings->displayName() }}</span>
        </a>

        <nav class="hidden items-center gap-1 md:flex" aria-label="Primary">
            <a
                href="{{ route('home') }}"
                class="rounded-lg px-3 py-2 text-sm font-medium text-zinc-600 transition hover:bg-zinc-100 hover:text-zinc-900 dark:text-zinc-300 dark:hover:bg-zinc-800 dark:hover:text-white"
            >{{ __('site.nav_home') }}</a>
            <a
                href="{{ route('home') }}#marketing-services"
                class="rounded-lg px-3 py-2 text-sm font-medium text-zinc-600 transition hover:bg-zinc-100 hover:text-zinc-900 dark:text-zinc-300 dark:hover:bg-zinc-800 dark:hover:text-white"
            >{{ __('site.nav_services') }}</a>
            <a
                href="{{ route('portfolio.index') }}"
                class="rounded-lg px-3 py-2 text-sm font-medium text-zinc-600 transition hover:bg-zinc-100 hover:text-zinc-900 dark:text-zinc-300 dark:hover:bg-zinc-800 dark:hover:text-white"
            >{{ __('site.nav_portfolio') }}</a>
            <a
                href="{{ route('home') }}#design-tools"
                class="rounded-lg px-3 py-2 text-sm font-medium text-zinc-600 transition hover:bg-zinc-100 hover:text-zinc-900 dark:text-zinc-300 dark:hover:bg-zinc-800 dark:hover:text-white"
            >{{ __('site.nav_tools') }}</a>
            <a
                href="{{ route('home') }}#faq"
                class="rounded-lg px-3 py-2 text-sm font-medium text-zinc-600 transition hover:bg-zinc-100 hover:text-zinc-900 dark:text-zinc-300 dark:hover:bg-zinc-800 dark:hover:text-white"
            >{{ __('site.nav_faq') }}</a>
            <a
                href="{{ route('contact') }}"
                class="rounded-lg bg-zinc-900 px-3 py-2 text-sm font-semibold text-white shadow-sm transition hover:bg-zinc-800 dark:bg-white dark:text-zinc-900 dark:hover:bg-zinc-200"
            >{{ __('site.nav_contact') }}</a>
        </nav>

        <div class="flex items-center gap-2">
            <div class="hidden items-center rounded-full border border-zinc-200 p-0.5 text-xs font-semibold dark:border-zinc-700 sm:flex">
                <a
                    href="{{ route('locale.switch', ['locale' => 'en']) }}"
                    class="rounded-full px-2.5 py-1 transition {{ app()->getLocale() === 'en' ? 'bg-zinc-900 text-white dark:bg-white dark:text-zinc-900' : 'text-zinc-500 hover:text-zinc-900 dark:hover:text-white' }}"
                >EN</a>
                <a
                    href="{{ route('locale.switch', ['locale' => 'my']) }}"
                    class="rounded-full px-2.5 py-1 transition {{ app()->getLocale() === 'my' ? 'bg-zinc-900 text-white dark:bg-white dark:text-zinc-900' : 'text-zinc-500 hover:text-zinc-900 dark:hover:text-white' }}"
                >MY</a>
            </div>

            <button
                type="button"
                class="rounded-full border border-zinc-200 p-2 text-zinc-600 transition hover:bg-zinc-100 dark:border-zinc-700 dark:text-zinc-300 dark:hover:bg-zinc-800"
                @click="toggleTheme()"
                :aria-pressed="dark"
                aria-label="{{ __('site.theme_dark') }}"
            >
                <span x-show="!dark" x-cloak class="block h-5 w-5">☾</span>
                <span x-show="dark" x-cloak class="block h-5 w-5">☀</span>
            </button>

            <details class="relative md:hidden">
                <summary class="list-none cursor-pointer rounded-lg border border-zinc-200 px-3 py-2 text-sm font-semibold dark:border-zinc-700">
                    Menu
                </summary>
                <div
                    class="absolute right-0 mt-2 w-52 rounded-xl border border-zinc-200 bg-white p-2 shadow-xl dark:border-zinc-700 dark:bg-zinc-900"
                >
                    <a href="{{ route('home') }}" class="block rounded-lg px-3 py-2 text-sm hover:bg-zinc-100 dark:hover:bg-zinc-800">{{ __('site.nav_home') }}</a>
                    <a href="{{ route('home') }}#marketing-services" class="block rounded-lg px-3 py-2 text-sm hover:bg-zinc-100 dark:hover:bg-zinc-800">{{ __('site.nav_services') }}</a>
                    <a href="{{ route('portfolio.index') }}" class="block rounded-lg px-3 py-2 text-sm hover:bg-zinc-100 dark:hover:bg-zinc-800">{{ __('site.nav_portfolio') }}</a>
                    <a href="{{ route('home') }}#design-tools" class="block rounded-lg px-3 py-2 text-sm hover:bg-zinc-100 dark:hover:bg-zinc-800">{{ __('site.nav_tools') }}</a>
                    <a href="{{ route('home') }}#faq" class="block rounded-lg px-3 py-2 text-sm hover:bg-zinc-100 dark:hover:bg-zinc-800">{{ __('site.nav_faq') }}</a>
                    <a href="{{ route('contact') }}" class="block rounded-lg px-3 py-2 text-sm font-semibold hover:bg-zinc-100 dark:hover:bg-zinc-800">{{ __('site.nav_contact') }}</a>
                    <div class="mt-2 flex gap-1 border-t border-zinc-100 pt-2 dark:border-zinc-800">
                        <a href="{{ route('locale.switch', ['locale' => 'en']) }}" class="flex-1 rounded-lg bg-zinc-100 py-2 text-center text-xs font-bold dark:bg-zinc-800">EN</a>
                        <a href="{{ route('locale.switch', ['locale' => 'my']) }}" class="flex-1 rounded-lg bg-zinc-100 py-2 text-center text-xs font-bold dark:bg-zinc-800">MY</a>
                    </div>
                </div>
            </details>
        </div>
    </div>
</header>
