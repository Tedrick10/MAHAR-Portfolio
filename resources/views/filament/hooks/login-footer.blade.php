{{-- Full-bleed bar (match admin login header edge-to-edge) --}}
<div class="relative left-1/2 w-screen max-w-[100vw] -translate-x-1/2">
    <footer class="w-full border-t border-zinc-200 bg-zinc-50 dark:border-zinc-800/90 dark:bg-zinc-950">
        <div class="mx-auto max-w-7xl px-4 py-8 text-center sm:px-6 sm:py-7 lg:px-8">
            <p class="text-sm leading-relaxed text-zinc-600 dark:text-zinc-400">
                <span class="text-zinc-500 dark:text-zinc-500">© {{ now()->year }} {{ \App\Models\WebsiteSetting::current()->displayName() }}.</span>
                <a
                    href="{{ route('home') }}"
                    class="ml-1 font-semibold text-amber-600 transition hover:text-amber-500 hover:underline dark:text-amber-500 dark:hover:text-amber-400"
                >
                    {{ __('admin.login_footer_website') }}
                </a>
            </p>
        </div>
    </footer>
</div>

@include('components.scroll-to-top')
