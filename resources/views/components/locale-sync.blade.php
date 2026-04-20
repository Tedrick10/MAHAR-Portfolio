{{-- Mirror session locale to localStorage; reload other tabs when locale changes elsewhere. --}}
<script>
    (function () {
        var serverLocale = @json(app()->getLocale());
        try {
            localStorage.setItem('locale', serverLocale);
        } catch (e) {}
        window.addEventListener('storage', function (e) {
            if (e.key === 'locale' && e.newValue && e.newValue !== serverLocale) {
                window.location.reload();
            }
        });
    })();
</script>
