<div
    x-data="{
        open: false,
        src: '',
        alt: '',
        openZoom(detail) {
            this.src = detail.src || '';
            this.alt = detail.alt || '';
            this.open = true;
            document.documentElement.classList.add('overflow-hidden');
        },
        close() {
            this.open = false;
            this.src = '';
            this.alt = '';
            document.documentElement.classList.remove('overflow-hidden');
        },
    }"
    @image-zoom.window="openZoom($event.detail)"
    @keydown.escape.window="close()"
>
    <div
        x-show="open"
        x-transition:enter="transition ease-out duration-200"
        x-transition:enter-start="opacity-0"
        x-transition:enter-end="opacity-100"
        x-transition:leave="transition ease-in duration-150"
        x-transition:leave-start="opacity-100"
        x-transition:leave-end="opacity-0"
        class="fixed inset-0 z-[200] flex items-center justify-center bg-black/90 p-4 backdrop-blur-sm"
        role="dialog"
        aria-modal="true"
        aria-label="{{ __('site.lightbox_label') }}"
    >
        <button
            type="button"
            class="absolute inset-0 cursor-zoom-out"
            @click="close()"
            aria-label="{{ __('site.lightbox_close') }}"
        ></button>
        <div class="relative z-10 max-h-[92vh] max-w-[min(96vw,1200px)]">
            <img
                x-show="open"
                x-transition:enter="transition ease-out duration-200"
                x-transition:enter-start="opacity-0 scale-95"
                x-transition:enter-end="opacity-100 scale-100"
                :src="src"
                :alt="alt"
                class="max-h-[92vh] w-auto max-w-full rounded-lg object-contain shadow-2xl ring-1 ring-white/10"
                decoding="async"
            />
            <p x-show="alt" class="mt-3 text-center text-sm text-zinc-300" x-text="alt"></p>
        </div>
        <button
            type="button"
            class="absolute right-4 top-4 z-20 flex h-11 w-11 items-center justify-center rounded-full bg-white/10 text-xl text-white ring-1 ring-white/20 transition hover:bg-white/20"
            @click.stop="close()"
            aria-label="{{ __('site.lightbox_close') }}"
        >×</button>
    </div>
</div>
