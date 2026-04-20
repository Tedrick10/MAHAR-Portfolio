<!DOCTYPE html>
<html
    lang="{{ str_replace('_', '-', app()->getLocale()) }}"
    class="h-full"
    x-data="siteRoot"
    x-init="initTheme()"
>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', \App\Models\WebsiteSetting::current()->displayName())</title>
    @include('components.theme-init-inline')
    @php
        $siteSettings = \App\Models\WebsiteSetting::current();
    @endphp
    @if ($siteSettings->faviconPublicUrl())
        <link rel="icon" href="{{ $siteSettings->faviconPublicUrl() }}" sizes="any">
    @endif
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Bebas+Neue&family=DM+Sans:ital,opsz,wght@0,9..40,400..700;1,9..40,400..700&family=Great+Vibes&family=Noto+Sans+Myanmar:wght@400;600;700&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="flex min-h-full flex-col font-sans">
    @include('components.site-header')
    <main class="flex-1">
        @yield('content')
    </main>
    @include('components.site-footer')
    @include('components.image-lightbox')
    @include('components.scroll-to-top')
    @include('components.locale-sync')
</body>
</html>
