@extends('layouts.public')

@section('title', __('site.nav_contact').' — '.\App\Models\WebsiteSetting::current()->displayName())

@section('content')
    <div class="bg-zinc-50 pb-20 pt-8 text-zinc-900 dark:bg-[#060d18] dark:text-zinc-100 sm:pb-24 sm:pt-10">
        <div class="mx-auto max-w-6xl px-4 text-center sm:px-6 lg:px-8">
            <h1 class="font-display text-3xl font-semibold tracking-tight text-zinc-900 dark:text-white sm:text-4xl md:text-5xl">
                {{ $settings->localized('contact_heading') }}
            </h1>
            @if ($settings->localized('contact_intro'))
                <p class="mx-auto mt-4 max-w-2xl text-sm leading-relaxed text-zinc-600 dark:text-zinc-400 sm:text-base">
                    {{ $settings->localized('contact_intro') }}
                </p>
            @endif
        </div>

        <div class="mx-auto mt-10 grid max-w-6xl gap-10 px-4 sm:px-6 lg:mt-14 lg:grid-cols-2 lg:items-start lg:gap-12 lg:px-8 xl:gap-16">
            {{-- Left: form (reference layout) --}}
            <div class="order-2 lg:order-1">
                <div class="rounded-2xl border border-zinc-200 bg-white p-6 shadow-lg shadow-zinc-900/5 dark:border-white/10 dark:bg-[#0c1628]/95 dark:shadow-xl dark:shadow-black/30 sm:p-8">
                    @if (session('status'))
                        <p class="mb-6 rounded-xl border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm font-medium text-emerald-800 dark:border-emerald-500/30 dark:bg-emerald-500/10 dark:text-emerald-100">
                            {{ session('status') }}
                        </p>
                    @endif

                    <form method="post" action="{{ route('contact.store') }}" class="space-y-5">
                        @csrf
                        <div class="grid gap-5 sm:grid-cols-2">
                            <div>
                                <label for="name" class="block text-xs font-semibold uppercase tracking-wide text-zinc-500 dark:text-zinc-400">{{ __('site.contact_field_name') }}</label>
                                <input
                                    id="name"
                                    name="name"
                                    value="{{ old('name') }}"
                                    required
                                    autocomplete="name"
                                    placeholder="{{ __('site.contact_placeholder_name') }}"
                                    class="mt-2 w-full rounded-xl border border-zinc-300 bg-white px-4 py-3 text-sm text-zinc-900 outline-none transition placeholder:text-zinc-400 focus:border-orange-500 focus:ring-2 focus:ring-orange-500/25 dark:border-white/10 dark:bg-[#080f1c] dark:text-white dark:placeholder:text-zinc-600 dark:focus:border-orange-500/70"
                                >
                                @error('name')
                                    <p class="mt-1.5 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                @enderror
                            </div>
                            <div>
                                <label for="email" class="block text-xs font-semibold uppercase tracking-wide text-zinc-500 dark:text-zinc-400">{{ __('site.contact_field_email') }}</label>
                                <input
                                    id="email"
                                    type="email"
                                    name="email"
                                    value="{{ old('email') }}"
                                    required
                                    autocomplete="email"
                                    placeholder="{{ __('site.contact_placeholder_email') }}"
                                    class="mt-2 w-full rounded-xl border border-zinc-300 bg-white px-4 py-3 text-sm text-zinc-900 outline-none transition placeholder:text-zinc-400 focus:border-orange-500 focus:ring-2 focus:ring-orange-500/25 dark:border-white/10 dark:bg-[#080f1c] dark:text-white dark:placeholder:text-zinc-600 dark:focus:border-orange-500/70"
                                >
                                @error('email')
                                    <p class="mt-1.5 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                        <div>
                            <label for="phone" class="block text-xs font-semibold uppercase tracking-wide text-zinc-500 dark:text-zinc-400">{{ __('site.contact_field_phone') }}</label>
                            <input
                                id="phone"
                                name="phone"
                                value="{{ old('phone') }}"
                                autocomplete="tel"
                                placeholder="{{ __('site.contact_placeholder_phone') }}"
                                class="mt-2 w-full rounded-xl border border-zinc-300 bg-white px-4 py-3 text-sm text-zinc-900 outline-none transition placeholder:text-zinc-400 focus:border-orange-500 focus:ring-2 focus:ring-orange-500/25 dark:border-white/10 dark:bg-[#080f1c] dark:text-white dark:placeholder:text-zinc-600 dark:focus:border-orange-500/70"
                            >
                            @error('phone')
                                <p class="mt-1.5 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>

                        <fieldset class="space-y-3">
                            <legend class="text-xs font-semibold uppercase tracking-wide text-zinc-500 dark:text-zinc-400">{{ __('site.contact_services_label') }}</legend>
                            <div class="grid gap-3 sm:grid-cols-2">
                                @foreach (['branding', 'identity', 'campaign', 'packaging', 'digital', 'other'] as $svc)
                                    <label class="flex cursor-pointer items-start gap-3 rounded-xl border border-zinc-200 bg-zinc-50 p-3 transition hover:border-orange-500/40 has-[:checked]:border-orange-500/50 has-[:checked]:bg-orange-500/10 dark:border-white/10 dark:bg-[#080f1c]/80">
                                        <input
                                            type="checkbox"
                                            name="services[]"
                                            value="{{ $svc }}"
                                            @checked(in_array($svc, old('services', []), true))
                                            class="mt-0.5 size-4 shrink-0 rounded border-zinc-300 bg-white text-orange-500 focus:ring-2 focus:ring-orange-500/40 focus:ring-offset-0 dark:border-white/20 dark:bg-[#060d18]"
                                        >
                                        <span class="text-sm leading-snug text-zinc-800 dark:text-zinc-200">{{ __('site.contact_service_'.$svc) }}</span>
                                    </label>
                                @endforeach
                            </div>
                            @error('services')
                                <p class="text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                            @error('services.*')
                                <p class="text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </fieldset>

                        <div>
                            <label for="message" class="block text-xs font-semibold uppercase tracking-wide text-zinc-500 dark:text-zinc-400">{{ __('site.contact_field_message') }}</label>
                            <textarea
                                id="message"
                                name="message"
                                rows="6"
                                required
                                placeholder="{{ __('site.contact_placeholder_message') }}"
                                class="mt-2 w-full resize-y rounded-xl border border-zinc-300 bg-white px-4 py-3 text-sm text-zinc-900 outline-none transition placeholder:text-zinc-400 focus:border-orange-500 focus:ring-2 focus:ring-orange-500/25 dark:border-white/10 dark:bg-[#080f1c] dark:text-white dark:placeholder:text-zinc-600 dark:focus:border-orange-500/70"
                            >{{ old('message') }}</textarea>
                            @error('message')
                                <p class="mt-1.5 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>

                        <button
                            type="submit"
                            class="w-full rounded-xl bg-gradient-to-r from-orange-600 to-red-600 py-3.5 text-sm font-semibold text-white shadow-lg shadow-orange-900/35 transition hover:from-orange-500 hover:to-red-500 focus:outline-none focus-visible:ring-2 focus-visible:ring-orange-400 focus-visible:ring-offset-2 focus-visible:ring-offset-white dark:focus-visible:ring-offset-[#0c1628]"
                        >{{ __('site.contact_submit_request') }}</button>
                    </form>
                </div>
            </div>

            {{-- Right: map + contact rows --}}
            <div class="order-1 space-y-6 lg:order-2">
                <div class="overflow-hidden rounded-2xl border border-zinc-200 bg-white shadow-lg shadow-zinc-900/5 ring-1 ring-zinc-900/5 dark:border-white/10 dark:bg-[#0c1628] dark:shadow-xl dark:shadow-black/30 dark:ring-white/5">
                    <div class="aspect-[4/3] min-h-[220px] w-full sm:aspect-[16/10] sm:min-h-[260px]">
                        <iframe
                            class="h-full w-full border-0"
                            src="{{ $mapsEmbedUrl }}"
                            title="{{ __('site.contact_map_iframe_title') }}"
                            loading="lazy"
                            allowfullscreen
                            referrerpolicy="no-referrer-when-downgrade"
                        ></iframe>
                    </div>
                </div>

                <div class="rounded-2xl border border-zinc-200 bg-white p-1 shadow-lg shadow-zinc-900/5 dark:border-white/10 dark:bg-[#0c1628]/95 dark:shadow-lg dark:shadow-black/20">
                    <ul class="divide-y divide-zinc-100 dark:divide-white/5">
                        @if ($settings->localized('contact_address'))
                            <li class="flex gap-4 p-4 sm:p-5">
                                <span class="flex h-11 w-11 shrink-0 items-center justify-center rounded-lg bg-gradient-to-br from-orange-600 to-red-600 text-white shadow-inner shadow-orange-950/30" aria-hidden="true">
                                    <svg class="h-5 w-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                                </span>
                                <div class="min-w-0 pt-0.5">
                                    <p class="text-xs font-bold uppercase tracking-wider text-zinc-500">{{ __('site.contact_label_studio') }}</p>
                                    <p class="mt-1 whitespace-pre-line text-sm font-medium leading-relaxed text-zinc-900 dark:text-zinc-100">{{ $settings->localized('contact_address') }}</p>
                                </div>
                            </li>
                        @endif
                        @if ($settings->contact_phone)
                            <li class="flex gap-4 p-4 sm:p-5">
                                <span class="flex h-11 w-11 shrink-0 items-center justify-center rounded-lg bg-gradient-to-br from-orange-600 to-red-600 text-white shadow-inner shadow-orange-950/30" aria-hidden="true">
                                    <svg class="h-5 w-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/></svg>
                                </span>
                                <div class="min-w-0 pt-0.5">
                                    <p class="text-xs font-bold uppercase tracking-wider text-zinc-500">{{ __('site.contact_label_phone') }}</p>
                                    <p class="mt-1 text-sm font-medium text-zinc-900 dark:text-zinc-100">{{ $settings->contact_phone }}</p>
                                </div>
                            </li>
                        @endif
                        @if ($settings->contact_email)
                            <li class="flex gap-4 p-4 sm:p-5">
                                <span class="flex h-11 w-11 shrink-0 items-center justify-center rounded-lg bg-gradient-to-br from-orange-600 to-red-600 text-white shadow-inner shadow-orange-950/30" aria-hidden="true">
                                    <svg class="h-5 w-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                                </span>
                                <div class="min-w-0 pt-0.5">
                                    <p class="text-xs font-bold uppercase tracking-wider text-zinc-500">{{ __('site.contact_label_email') }}</p>
                                    <a class="mt-1 inline-block break-all text-sm font-medium text-orange-600 transition hover:text-orange-700 dark:text-orange-300 dark:hover:text-orange-200" href="mailto:{{ $settings->contact_email }}">{{ $settings->contact_email }}</a>
                                </div>
                            </li>
                        @endif
                        @if ($settings->localized('contact_hours'))
                            <li class="flex gap-4 p-4 sm:p-5">
                                <span class="flex h-11 w-11 shrink-0 items-center justify-center rounded-lg bg-gradient-to-br from-orange-600 to-red-600 text-white shadow-inner shadow-orange-950/30" aria-hidden="true">
                                    <svg class="h-5 w-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                </span>
                                <div class="min-w-0 pt-0.5">
                                    <p class="text-xs font-bold uppercase tracking-wider text-zinc-500">{{ __('site.contact_hours_label') }}</p>
                                    <p class="mt-1 text-sm font-medium text-zinc-900 dark:text-zinc-100">{{ $settings->localized('contact_hours') }}</p>
                                </div>
                            </li>
                        @endif
                    </ul>
                </div>
            </div>
        </div>
    </div>
@endsection
