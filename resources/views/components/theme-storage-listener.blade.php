{{-- When another tab updates localStorage "theme", keep this document in sync (Filament has no public Alpine siteRoot). --}}
<script>
    (function () {
        window.addEventListener('storage', function (e) {
            if (e.key !== 'theme') {
                return;
            }
            try {
                var t = localStorage.getItem('theme');
                var d = false;
                if (t === 'dark') d = true;
                else if (t === 'light') d = false;
                else d = window.matchMedia('(prefers-color-scheme: dark)').matches;
                document.documentElement.classList.toggle('dark', d);
                window.dispatchEvent(
                    new CustomEvent('app:theme-changed', { detail: { resolvedDark: d, fromStorage: true } }),
                );
            } catch (err) {}
        });
    })();
</script>
