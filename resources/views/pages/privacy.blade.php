@extends('layouts.public')

@section('title', __('legal.privacy_title').' — '.\App\Models\WebsiteSetting::current()->displayName())

@section('content')
    <article class="mx-auto max-w-3xl px-4 py-14 sm:px-6 sm:py-16 lg:px-8">
        <p class="text-xs font-bold uppercase tracking-[0.2em] text-orange-600 dark:text-orange-400">{{ __('legal.privacy_kicker') }}</p>
        <h1 class="mt-3 font-display text-3xl font-semibold tracking-tight text-zinc-900 dark:text-white sm:text-4xl">
            {{ __('legal.privacy_title') }}
        </h1>
        <div class="mt-8 space-y-4 text-sm leading-relaxed text-zinc-600 dark:text-zinc-400">
            <p>{{ __('legal.privacy_p1') }}</p>
            <p>{{ __('legal.privacy_p2') }}</p>
            <p>{{ __('legal.privacy_p3') }}</p>
        </div>
        <p class="mt-10">
            <a href="{{ route('home') }}" class="text-sm font-semibold text-orange-600 transition hover:underline dark:text-orange-400">← {{ __('site.nav_home') }}</a>
        </p>
    </article>
@endsection
