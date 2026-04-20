<div class="mt-8 w-full">
    <button
        type="button"
        wire:click="fillDemoCredentials"
        aria-label="{{ __('admin.demo_login_aria') }}"
        class="w-full cursor-pointer rounded-2xl border border-dashed border-amber-500/50 bg-amber-500/5 p-4 text-left transition hover:border-amber-500 hover:bg-amber-500/10 focus:outline-none focus-visible:ring-2 focus-visible:ring-amber-500 focus-visible:ring-offset-2 focus-visible:ring-offset-zinc-950 dark:focus-visible:ring-offset-zinc-950"
    >
        <p class="font-mono text-[11px] leading-relaxed text-zinc-500 dark:text-zinc-400">
            <span class="text-zinc-400 dark:text-zinc-500">{{ __('admin.demo_login_email_label') }}</span>
            {{ config('demo-login.email') }}<br>
            <span class="text-zinc-400 dark:text-zinc-500">{{ __('admin.demo_login_password_label') }}</span>
            {{ config('demo-login.password') }}
        </p>
    </button>
</div>
