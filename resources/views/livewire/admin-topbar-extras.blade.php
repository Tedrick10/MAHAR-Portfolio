@php
    use Filament\Support\Icons\Heroicon;

    $dashboardUrl = \Filament\Facades\Filament::getUrl();
    $homeUrl = route('home');
    $isDashboard = request()->routeIs('filament.admin.pages.dashboard');
    $locale = app()->getLocale();
@endphp

<div
    wire:poll.1s
    class="fi-admin-topbar-extras flex min-w-0 max-w-full flex-nowrap items-center gap-x-1 overflow-x-auto sm:gap-x-2 [&::-webkit-scrollbar]:hidden [-ms-overflow-style:none] [scrollbar-width:none]"
>
    <a
        href="{{ $dashboardUrl }}"
        @class([
            'group flex shrink-0 items-center gap-x-2 rounded-lg px-2.5 py-2 text-sm font-semibold outline-none transition duration-75 sm:px-3',
            'bg-zinc-100 text-zinc-900 ring-1 ring-zinc-300 dark:bg-amber-500/15 dark:text-amber-400 dark:ring-amber-500/35 dark:shadow-sm dark:shadow-amber-500/10' => $isDashboard,
            'text-zinc-900 hover:bg-zinc-100 dark:text-gray-200 dark:hover:bg-white/5' => ! $isDashboard,
        ])
    >
        {{
            \Filament\Support\generate_icon_html(
                Heroicon::OutlinedHome,
                attributes: (new \Illuminate\View\ComponentAttributeBag)->class([
                    'h-5 w-5 shrink-0',
                    $isDashboard
                        ? 'text-zinc-800 dark:text-amber-400'
                        : 'text-zinc-600 group-hover:text-zinc-900 dark:text-gray-400 dark:group-hover:text-gray-200',
                ]),
            )
        }}
        <span class="hidden whitespace-nowrap sm:inline">{{ __('admin.topbar_dashboard') }}</span>
    </a>

    <a
        href="{{ $homeUrl }}"
        target="_blank"
        rel="noopener noreferrer"
        class="hidden shrink-0 items-center gap-x-2 rounded-lg px-2.5 py-2 text-sm font-medium text-zinc-900 outline-none transition duration-75 hover:bg-zinc-100 dark:text-gray-100 dark:hover:bg-white/5 sm:flex sm:px-3"
    >
        {{
            \Filament\Support\generate_icon_html(
                Heroicon::OutlinedArrowTopRightOnSquare,
                attributes: (new \Illuminate\View\ComponentAttributeBag)->class(['h-5 w-5 shrink-0 text-zinc-600 dark:text-gray-400']),
            )
        }}
        <span class="hidden whitespace-nowrap sm:inline">{{ __('admin.topbar_view_site') }}</span>
    </a>

    <x-filament::dropdown placement="bottom-end" :teleport="true">
        <x-slot name="trigger">
            <button
                type="button"
                class="flex shrink-0 items-center gap-x-1.5 rounded-lg border border-zinc-300 bg-white px-2 py-2 text-sm font-medium text-zinc-900 outline-none transition hover:border-zinc-400 hover:bg-zinc-50 dark:border-gray-600 dark:bg-gray-900/40 dark:text-gray-100 dark:hover:border-gray-500 dark:hover:bg-white/5 sm:gap-x-2 sm:px-3"
            >
                <span class="text-base leading-none" aria-hidden="true">{{ $locale === 'my' ? '🇲🇲' : '🇬🇧' }}</span>
                <span class="whitespace-nowrap">{{ $locale === 'my' ? 'MY' : 'EN' }}</span>
                {{
                    \Filament\Support\generate_icon_html(
                        Heroicon::OutlinedChevronDown,
                        attributes: (new \Illuminate\View\ComponentAttributeBag)->class(['h-4 w-4 shrink-0 text-zinc-500 dark:text-gray-400']),
                    )
                }}
            </button>
        </x-slot>

        <x-filament::dropdown.list>
            <x-filament::dropdown.list.item
                :href="route('locale.switch', ['locale' => 'en'])"
                tag="a"
                :icon="Heroicon::OutlinedLanguage"
            >
                {{ __('site.lang_en') }}
            </x-filament::dropdown.list.item>
            <x-filament::dropdown.list.item
                :href="route('locale.switch', ['locale' => 'my'])"
                tag="a"
                :icon="Heroicon::OutlinedLanguage"
            >
                {{ __('site.lang_my') }}
            </x-filament::dropdown.list.item>
        </x-filament::dropdown.list>
    </x-filament::dropdown>

    @if (filament()->hasDarkMode() && (! filament()->hasDarkModeForced()))
        <x-filament::dropdown placement="bottom-end" :teleport="true">
            <x-slot name="trigger">
                <button
                    type="button"
                class="flex shrink-0 items-center gap-x-1.5 rounded-lg border border-zinc-300 bg-white px-2 py-2 text-sm font-medium text-zinc-900 outline-none transition hover:border-zinc-400 hover:bg-zinc-50 dark:border-gray-600 dark:bg-gray-900/40 dark:text-gray-100 dark:hover:border-gray-500 dark:hover:bg-white/5 sm:gap-x-2 sm:px-3"
                >
                    {{
                        \Filament\Support\generate_icon_html(
                            Heroicon::OutlinedComputerDesktop,
                            attributes: (new \Illuminate\View\ComponentAttributeBag)->class(['h-5 w-5 shrink-0 text-zinc-600 dark:text-gray-400']),
                        )
                    }}
                    <span
                        class="min-w-0 text-left text-xs sm:min-w-[4rem] sm:text-sm"
                        x-data="{
                            v: 'system',
                            read() {
                                this.v = localStorage.getItem('theme') || @js(filament()->getDefaultThemeMode()->value);
                            },
                        }"
                        x-init="read(); setInterval(() => read(), 400);"
                        x-text="({
                            light: window.innerWidth < 640 ? 'Light' : @js(__('admin.topbar_theme_light')),
                            dark: window.innerWidth < 640 ? 'Dark' : @js(__('admin.topbar_theme_dark')),
                            system: window.innerWidth < 640 ? 'Auto' : @js(__('admin.topbar_theme_system')),
                        })[v] ?? (window.innerWidth < 640 ? 'Auto' : @js(__('admin.topbar_theme_system')))"
                    >{{ __('admin.topbar_theme_system') }}</span>
                    {{
                        \Filament\Support\generate_icon_html(
                            Heroicon::OutlinedChevronDown,
                            attributes: (new \Illuminate\View\ComponentAttributeBag)->class(['h-4 w-4 shrink-0 text-zinc-500 dark:text-gray-400']),
                        )
                    }}
                </button>
            </x-slot>

            <x-filament::dropdown.list>
                <x-filament::dropdown.list.item
                    :icon="Heroicon::OutlinedSun"
                    x-on:click="
                        localStorage.setItem('theme', 'light');
                        document.documentElement.classList.remove('dark');
                        window.dispatchEvent(new CustomEvent('app:theme-changed', { detail: { mode: 'light', resolvedDark: false } }));
                    "
                >
                    {{ __('admin.topbar_theme_light') }}
                </x-filament::dropdown.list.item>
                <x-filament::dropdown.list.item
                    :icon="Heroicon::OutlinedMoon"
                    x-on:click="
                        localStorage.setItem('theme', 'dark');
                        document.documentElement.classList.add('dark');
                        window.dispatchEvent(new CustomEvent('app:theme-changed', { detail: { mode: 'dark', resolvedDark: true } }));
                    "
                >
                    {{ __('admin.topbar_theme_dark') }}
                </x-filament::dropdown.list.item>
                <x-filament::dropdown.list.item
                    :icon="Heroicon::OutlinedComputerDesktop"
                    x-on:click="
                        localStorage.setItem('theme', 'system');
                        const dark = window.matchMedia('(prefers-color-scheme: dark)').matches;
                        document.documentElement.classList.toggle('dark', dark);
                        window.dispatchEvent(new CustomEvent('app:theme-changed', { detail: { mode: 'system', resolvedDark: dark } }));
                    "
                >
                    {{ __('admin.topbar_theme_system') }}
                </x-filament::dropdown.list.item>
            </x-filament::dropdown.list>
        </x-filament::dropdown>
    @endif

    <x-filament::dropdown placement="bottom-end" width="md" :teleport="true">
        <x-slot name="trigger">
            <button
                type="button"
                class="relative flex shrink-0 items-center justify-center rounded-lg p-2 text-zinc-900 outline-none transition hover:bg-zinc-100 dark:text-gray-200 dark:hover:bg-white/5"
                aria-label="{{ __('admin.topbar_notifications_aria') }}"
            >
                {{
                    \Filament\Support\generate_icon_html(
                        Heroicon::OutlinedBell,
                        attributes: (new \Illuminate\View\ComponentAttributeBag)->class(['h-6 w-6 shrink-0 text-zinc-800 dark:text-gray-300']),
                    )
                }}
                @if ($this->unreadCount > 0)
                    <span
                        class="absolute -end-0.5 -top-0.5 flex h-5 min-w-5 items-center justify-center rounded-full bg-amber-500 px-1 text-[10px] font-bold text-white shadow-sm dark:bg-amber-500 dark:text-gray-950"
                    >{{ $this->unreadCount > 99 ? '99+' : $this->unreadCount }}</span>
                @endif
            </button>
        </x-slot>

        <x-filament::dropdown.header :icon="Heroicon::OutlinedBell">
            {{ __('admin.topbar_notifications_title') }}
            @if ($this->unreadCount > 0)
                <x-filament::badge class="ms-2 align-middle" color="primary" size="sm">{{ $this->unreadCount }}</x-filament::badge>
            @endif
        </x-filament::dropdown.header>

        @if ($this->recentUnread->isEmpty())
            <div class="px-3 py-4 text-center text-sm text-gray-500 dark:text-gray-400">
                {{ __('admin.topbar_notifications_empty') }}
            </div>
        @else
            <x-filament::dropdown.list>
                @foreach ($this->recentUnread as $msg)
                    <x-filament::dropdown.list.item
                        :href="\App\Filament\Resources\ContactMessages\ContactMessageResource::getUrl('edit', ['record' => $msg])"
                        tag="a"
                    >
                        <div class="flex min-w-0 flex-col gap-0.5">
                            <span class="truncate font-semibold text-gray-950 dark:text-white">{{ $msg->name }}</span>
                            <span class="truncate text-xs text-gray-500 dark:text-gray-400">{{ $msg->email }}</span>
                            <span class="line-clamp-2 text-xs text-gray-600 dark:text-gray-300">{{ \Illuminate\Support\Str::limit(strip_tags($msg->message), 120) }}</span>
                        </div>
                    </x-filament::dropdown.list.item>
                @endforeach
            </x-filament::dropdown.list>
        @endif

        <x-filament::dropdown.list>
            <x-filament::dropdown.list.item
                :href="\App\Filament\Resources\ContactMessages\ContactMessageResource::getUrl()"
                tag="a"
                :icon="Heroicon::OutlinedInbox"
            >
                {{ __('admin.topbar_notifications_inbox') }}
            </x-filament::dropdown.list.item>
        </x-filament::dropdown.list>
    </x-filament::dropdown>
</div>
