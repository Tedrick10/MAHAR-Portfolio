{{-- Full-bleed header (match frontend edge-to-edge bar inside Filament simple layout) --}}
<div class="relative left-1/2 z-[60] w-screen max-w-[100vw] -translate-x-1/2">
    <div
        class="fi-login-public-header bg-white/95 backdrop-blur-md dark:bg-zinc-950/95"
        x-data="{
            dark: false,
            sync() {
                this.dark = document.documentElement.classList.contains('dark');
            },
            init() {
                this.sync();
                new MutationObserver(() => this.sync()).observe(document.documentElement, { attributes: true, attributeFilter: ['class'] });
            },
            toggleTheme() {
                const next = !document.documentElement.classList.contains('dark');
                document.documentElement.classList.toggle('dark', next);
                localStorage.setItem('theme', next ? 'dark' : 'light');
                this.dark = next;
                window.dispatchEvent(
                    new CustomEvent('app:theme-changed', { detail: { mode: next ? 'dark' : 'light', resolvedDark: next } }),
                );
            },
        }"
    >
        @include('components.site-header')
    </div>
</div>
