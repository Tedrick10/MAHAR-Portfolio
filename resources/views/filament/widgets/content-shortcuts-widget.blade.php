@php
    $groups = $groups ?? [];
@endphp

<x-filament-widgets::widget class="fi-admin-content-shortcuts @container min-w-0">
    <x-filament::section
        :heading="__('admin.dashboard_shortcuts_heading')"
        :description="__('admin.dashboard_shortcuts_description')"
    >
        <div class="space-y-8">
            @foreach ($groups as $group)
                <div class="space-y-3">
                    <div class="border-b border-zinc-200 pb-2 dark:border-white/10">
                        <h3 class="text-sm font-semibold text-zinc-900 dark:text-white">
                            {{ $group['title'] }}
                        </h3>
                        @if (! empty($group['description']))
                            <p class="mt-0.5 text-xs text-zinc-500 dark:text-zinc-400">
                                {{ $group['description'] }}
                            </p>
                        @endif
                    </div>

                    <ul class="grid grid-cols-1 gap-3 @md:grid-cols-2 @xl:grid-cols-3">
                        @foreach ($group['items'] as $item)
                            <li>
                                <a
                                    href="{{ $item['url'] }}"
                                    class="group flex items-start gap-3 rounded-xl border border-zinc-200 bg-white p-4 shadow-sm outline-none transition hover:border-primary-400 hover:shadow-md focus-visible:ring-2 focus-visible:ring-primary-500 dark:border-white/10 dark:bg-zinc-900 dark:hover:border-amber-500/50 dark:hover:shadow-amber-500/10"
                                >
                                    <span
                                        class="flex h-10 w-10 shrink-0 items-center justify-center rounded-lg bg-zinc-100 text-zinc-700 ring-1 ring-zinc-200/80 dark:bg-white/5 dark:text-amber-400 dark:ring-white/10"
                                    >
                                        {{
                                            \Filament\Support\generate_icon_html(
                                                $item['icon'],
                                                attributes: (new \Illuminate\View\ComponentAttributeBag)->class([
                                                    'h-5 w-5',
                                                ]),
                                            )
                                        }}
                                    </span>
                                    <span class="min-w-0 flex-1">
                                        <span class="flex flex-wrap items-center gap-2">
                                            <span
                                                class="break-words text-sm font-semibold leading-snug text-zinc-900 group-hover:text-primary-600 dark:text-white dark:group-hover:text-amber-400"
                                            >
                                                {{ $item['label'] }}
                                            </span>
                                            @if (! empty($item['badge']))
                                                <x-filament::badge :color="$item['badgeColor'] ?? 'primary'">
                                                    {{ $item['badge'] }}
                                                </x-filament::badge>
                                            @endif
                                        </span>
                                        @if (! empty($item['hint']))
                                            <span class="mt-0.5 block text-xs text-zinc-500 dark:text-zinc-400">
                                                {{ $item['hint'] }}
                                            </span>
                                        @endif
                                    </span>
                                </a>
                            </li>
                        @endforeach
                    </ul>
                </div>
            @endforeach
        </div>
    </x-filament::section>
</x-filament-widgets::widget>
