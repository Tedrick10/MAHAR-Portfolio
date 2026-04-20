<div
    x-data="{
        show: false,
        onScroll() {
            this.show = window.scrollY > 280;
        },
        scrollTop() {
            window.scrollTo({
                top: 0,
                behavior: window.matchMedia('(prefers-reduced-motion: reduce)').matches ? 'auto' : 'smooth',
            });
        },
    }"
    x-init="
        onScroll();
        window.addEventListener('scroll', () => onScroll(), { passive: true });
    "
    class="pointer-events-none fixed bottom-5 right-4 z-[90] sm:bottom-8 sm:right-6"
>
    <button
        type="button"
        x-cloak
        x-show="show"
        x-transition:enter="transition ease-out duration-200"
        x-transition:enter-start="translate-y-2 opacity-0"
        x-transition:enter-end="translate-y-0 opacity-100"
        x-transition:leave="transition ease-in duration-150"
        x-transition:leave-start="translate-y-0 opacity-100"
        x-transition:leave-end="translate-y-2 opacity-0"
        class="pointer-events-auto flex h-11 w-11 items-center justify-center rounded-full bg-white text-zinc-800 shadow-lg shadow-zinc-900/10 ring-1 ring-zinc-200 transition hover:-translate-y-0.5 hover:bg-zinc-50 focus:outline-none focus-visible:ring-2 focus-visible:ring-orange-500 focus-visible:ring-offset-2 focus-visible:ring-offset-zinc-50 dark:bg-zinc-900 dark:text-white dark:shadow-zinc-900/25 dark:ring-white/10 dark:hover:bg-zinc-800 dark:focus-visible:ring-offset-zinc-950"
        @click="scrollTop()"
        aria-label="{{ __('site.scroll_to_top') }}"
    >
        <svg
            class="h-5 w-5 shrink-0"
            viewBox="0 0 24 24"
            fill="none"
            stroke="currentColor"
            stroke-width="2.25"
            stroke-linecap="round"
            stroke-linejoin="round"
            aria-hidden="true"
        >
            <path d="M5 15 12 8l7 7" />
        </svg>
    </button>
</div>
