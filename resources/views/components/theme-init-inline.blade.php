{{-- Must run before CSS to avoid flash. Same logic as resources/js/theme-sync.js resolveIsDark(). --}}
<script>
    (function () {
        try {
            var t = localStorage.getItem('theme');
            var d = false;
            if (t === 'dark') d = true;
            else if (t === 'light') d = false;
            else d = window.matchMedia('(prefers-color-scheme: dark)').matches;
            document.documentElement.classList.toggle('dark', d);
        } catch (e) {}
    })();
</script>
