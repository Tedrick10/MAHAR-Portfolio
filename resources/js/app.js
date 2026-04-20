import Alpine from 'alpinejs';
import intersect from '@alpinejs/intersect';
import {
    resolveIsDark,
    applyDarkClass,
    bindThemeCrossTab,
    bindSystemPreferenceChange,
    dispatchThemeChanged,
} from './theme-sync';

Alpine.plugin(intersect);

document.addEventListener('alpine:init', () => {
    Alpine.data('siteRoot', () => ({
        dark: false,
        initTheme() {
            this.dark = resolveIsDark();
            applyDarkClass(this.dark);
            bindThemeCrossTab((isDark) => {
                this.dark = isDark;
            });
            bindSystemPreferenceChange();
            window.addEventListener('app:theme-changed', (e) => {
                const d = e.detail;
                if (! d) {
                    return;
                }
                if (d.resolvedDark !== undefined) {
                    this.dark = d.resolvedDark;
                } else if (d.mode === 'dark') {
                    this.dark = true;
                } else if (d.mode === 'light') {
                    this.dark = false;
                } else if (d.mode === 'system' || d.fromStorage || d.fromSystem) {
                    this.dark = resolveIsDark();
                }
            });
        },
        toggleTheme() {
            const nextDark = ! this.dark;
            this.dark = nextDark;
            const mode = nextDark ? 'dark' : 'light';
            try {
                localStorage.setItem('theme', mode);
            } catch (e) {}
            applyDarkClass(nextDark);
            dispatchThemeChanged({ mode, resolvedDark: nextDark });
        },
    }));
});

window.Alpine = Alpine;

Alpine.start();
