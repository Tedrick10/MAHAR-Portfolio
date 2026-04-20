/**
 * Shared theme (light / dark / system) for public site, admin login header, and Filament panel.
 * Single localStorage key: "theme" — values: "light" | "dark" | "system" | null (treated as system).
 */
export function getStoredTheme() {
    try {
        return localStorage.getItem('theme');
    } catch {
        return null;
    }
}

export function resolveIsDark() {
    const stored = getStoredTheme();
    if (stored === 'dark') {
        return true;
    }
    if (stored === 'light') {
        return false;
    }
    return window.matchMedia('(prefers-color-scheme: dark)').matches;
}

export function applyDarkClass(isDark) {
    document.documentElement.classList.toggle('dark', isDark);
}

export function dispatchThemeChanged(detail = {}) {
    window.dispatchEvent(new CustomEvent('app:theme-changed', { detail }));
}

export function bindThemeCrossTab(onResolved) {
    if (window.__themeCrossTabBound) {
        return;
    }
    window.__themeCrossTabBound = true;
    window.addEventListener('storage', (e) => {
        if (e.key !== 'theme') {
            return;
        }
        const isDark = resolveIsDark();
        applyDarkClass(isDark);
        dispatchThemeChanged({ resolvedDark: isDark, fromStorage: true });
        if (typeof onResolved === 'function') {
            onResolved(isDark);
        }
    });
}

export function bindSystemPreferenceChange() {
    if (window.__themeSystemPrefBound) {
        return;
    }
    window.__themeSystemPrefBound = true;
    window.matchMedia('(prefers-color-scheme: dark)').addEventListener('change', () => {
        const stored = getStoredTheme();
        if (stored === 'light' || stored === 'dark') {
            return;
        }
        const isDark = resolveIsDark();
        applyDarkClass(isDark);
        dispatchThemeChanged({ resolvedDark: isDark, fromSystem: true });
    });
}
