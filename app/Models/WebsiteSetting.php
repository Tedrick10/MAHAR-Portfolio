<?php

namespace App\Models;

use App\Models\Concerns\HasLocalizedColumns;
use App\Models\Concerns\ResolvesPublicMediaUrl;
use Illuminate\Contracts\Support\Htmlable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\HtmlString;

class WebsiteSetting extends Model
{
    use HasLocalizedColumns;
    use ResolvesPublicMediaUrl;

    protected $guarded = [];

    /**
     * Load the singleton settings row from the database every time (no once()/static cache).
     * Cached instances caused stale copy on the public site after Admin saves; a fresh SELECT per call is cheap for one row.
     */
    public static function current(): self
    {
        return static::query()->first() ?? static::query()->create([]);
    }

    protected function casts(): array
    {
        return [
            'marketing_services' => 'array',
            'hero_image_paths' => 'array',
        ];
    }

    /**
     * Public “Services & plans” section copy. Column prefix matches lang keys under `site.*` (e.g. services_lab_kicker_en).
     * When a DB value is empty, falls back to the translation file.
     */
    public function servicesCopy(string $prefix): string
    {
        // Columns are `{prefix}_en` / `{prefix}_my` — not `{prefix}__en` (suffix must not include a leading underscore).
        $suffix = str_starts_with((string) app()->getLocale(), 'my') ? 'my' : 'en';
        $column = $prefix.'_'.$suffix;

        // Use getAttributes(), not $this->attributes[…]: direct array access can miss hydrated values in some setups.
        $value = $this->getAttributes()[$column] ?? null;

        if (is_string($value) && trim($value) !== '') {
            return $value;
        }

        return (string) __("site.{$prefix}");
    }

    /**
     * Homepage “Our services” block (Facebook + TikTok). Stored JSON is deep-merged onto config defaults so admin
     * edits always win while missing keys still fall back to defaults (same behaviour as the Filament form).
     *
     * @return array<string, mixed>
     */
    public function marketingServicesResolved(): array
    {
        /** @var array<string, mixed> $defaults */
        $defaults = config('marketing_services', []);
        $stored = $this->marketing_services;

        if (! is_array($stored) || $stored === []) {
            $merged = $defaults;
        } else {
            $merged = array_replace_recursive($defaults, $stored);
            // array_replace_recursive keeps extra numeric indices from $defaults when $stored has
            // fewer repeater rows (e.g. deleted feature bullets). Overlay list-shaped keys from DB.
            $merged = $this->applyStoredMarketingServiceLists($merged, $stored);
        }

        $merged = $this->normalizeMarketingServicesFootnoteShape($merged);
        $merged = $this->normalizeMarketingServicesBrandingPackages($merged);

        return $this->normalizeMarketingServicesMonthlyPackages($merged);
    }

    /**
     * After array_replace_recursive(), trailing list entries from config defaults can remain when the
     * admin removed repeater rows. When the DB explicitly saved a shorter list, use that list verbatim.
     *
     * @param  array<string, mixed>  $merged
     * @param  array<string, mixed>  $stored
     * @return array<string, mixed>
     */
    private function applyStoredMarketingServiceLists(array $merged, array $stored): array
    {
        $fbStored = $stored['facebook'] ?? null;
        if (is_array($fbStored)) {
            $brandingStored = $fbStored['branding'] ?? null;
            if (is_array($brandingStored)) {
                foreach ($brandingStored as $i => $pkg) {
                    if (! is_array($pkg) || ! array_key_exists('items', $pkg) || ! is_array($pkg['items'])) {
                        continue;
                    }
                    if (! isset($merged['facebook']['branding'][$i]) || ! is_array($merged['facebook']['branding'][$i])) {
                        continue;
                    }
                    $merged['facebook']['branding'][$i]['items'] = array_values($pkg['items']);
                }
            }

            $monthlyStored = $fbStored['monthly'] ?? null;
            if (is_array($monthlyStored)) {
                foreach ($monthlyStored as $i => $plan) {
                    if (! is_array($plan) || ! array_key_exists('features', $plan) || ! is_array($plan['features'])) {
                        continue;
                    }
                    if (! isset($merged['facebook']['monthly'][$i]) || ! is_array($merged['facebook']['monthly'][$i])) {
                        continue;
                    }
                    $merged['facebook']['monthly'][$i]['features'] = array_values($plan['features']);
                }
            }
        }

        $ttStored = $stored['tiktok'] ?? null;
        if (is_array($ttStored)) {
            if (array_key_exists('plan_labels', $ttStored) && is_array($ttStored['plan_labels'])) {
                $merged['tiktok']['plan_labels'] = array_values($ttStored['plan_labels']);
            }
            if (array_key_exists('rows', $ttStored) && is_array($ttStored['rows'])) {
                $merged['tiktok']['rows'] = array_values($ttStored['rows']);
            }
            if (array_key_exists('per_video', $ttStored) && is_array($ttStored['per_video'])) {
                $merged['tiktok']['per_video'] = array_values($ttStored['per_video']);
            }
            if (array_key_exists('totals', $ttStored) && is_array($ttStored['totals'])) {
                $merged['tiktok']['totals'] = array_values($ttStored['totals']);
            }
        }

        return $merged;
    }

    /**
     * Legacy rows sometimes saved `tiktok.footnote` as a plain string; the view expects bilingual `{ en, my }`.
     *
     * @param  array<string, mixed>  $merged
     * @return array<string, mixed>
     */
    private function normalizeMarketingServicesFootnoteShape(array $merged): array
    {
        $footnote = $merged['tiktok']['footnote'] ?? null;

        if (is_string($footnote) && $footnote !== '') {
            $merged['tiktok']['footnote'] = [
                'en' => $footnote,
                'my' => $footnote,
            ];
        }

        return $merged;
    }

    /**
     * Branding packages: drop legacy `revision`, ensure price/currency and bilingual `option` labels.
     * Fills missing fields from config defaults; derives legacy price from old revision text if needed.
     *
     * @param  array<string, mixed>  $merged
     * @return array<string, mixed>
     */
    private function normalizeMarketingServicesBrandingPackages(array $merged): array
    {
        /** @var array<int, mixed> $defaults */
        $defaults = config('marketing_services.facebook.branding', []);

        if (! isset($merged['facebook']) || ! is_array($merged['facebook'])) {
            return $merged;
        }

        $branding = $merged['facebook']['branding'] ?? null;
        if (! is_array($branding)) {
            return $merged;
        }

        foreach ($branding as $i => $pkg) {
            if (! is_array($pkg)) {
                continue;
            }

            /** @var array<string, mixed> $pkg */
            unset($merged['facebook']['branding'][$i]['revision']);

            $def = isset($defaults[$i]) && is_array($defaults[$i]) ? $defaults[$i] : [];

            $defOpt = is_array($def['option'] ?? null) ? $def['option'] : ['en' => '', 'my' => ''];
            $opt = is_array($pkg['option'] ?? null) ? $pkg['option'] : [];
            $merged['facebook']['branding'][$i]['option'] = [
                'en' => is_string($opt['en'] ?? null) && trim((string) $opt['en']) !== ''
                    ? (string) $opt['en']
                    : (string) ($defOpt['en'] ?? ''),
                'my' => is_string($opt['my'] ?? null) && trim((string) $opt['my']) !== ''
                    ? (string) $opt['my']
                    : (string) ($defOpt['my'] ?? ''),
            ];

            $price = $pkg['price'] ?? null;
            if (! is_string($price) || trim($price) === '') {
                $price = $this->marketingServicesLegacyPriceFromRevision($pkg);
            }
            if (! is_string($price) || trim($price) === '') {
                $price = is_array($def) && isset($def['price']) && is_string($def['price']) ? $def['price'] : '';
            }
            $merged['facebook']['branding'][$i]['price'] = $price;

            $currency = $pkg['currency'] ?? null;
            if (! is_string($currency) || trim($currency) === '') {
                $currency = is_array($def) && isset($def['currency']) && is_string($def['currency'])
                    ? $def['currency']
                    : 'MMK';
            }
            $merged['facebook']['branding'][$i]['currency'] = $currency;
        }

        return $merged;
    }

    /**
     * Monthly (Social Media Marketing) plans: bilingual `option` labels; fill from config when missing.
     *
     * @param  array<string, mixed>  $merged
     * @return array<string, mixed>
     */
    private function normalizeMarketingServicesMonthlyPackages(array $merged): array
    {
        /** @var array<int, mixed> $defaults */
        $defaults = config('marketing_services.facebook.monthly', []);

        if (! isset($merged['facebook']) || ! is_array($merged['facebook'])) {
            return $merged;
        }

        $monthly = $merged['facebook']['monthly'] ?? null;
        if (! is_array($monthly)) {
            return $merged;
        }

        foreach ($monthly as $i => $plan) {
            if (! is_array($plan)) {
                continue;
            }

            $def = isset($defaults[$i]) && is_array($defaults[$i]) ? $defaults[$i] : [];
            $defOpt = is_array($def['option'] ?? null) ? $def['option'] : ['en' => '', 'my' => ''];
            $opt = is_array($plan['option'] ?? null) ? $plan['option'] : [];
            $merged['facebook']['monthly'][$i]['option'] = [
                'en' => is_string($opt['en'] ?? null) && trim((string) $opt['en']) !== ''
                    ? (string) $opt['en']
                    : (string) ($defOpt['en'] ?? ''),
                'my' => is_string($opt['my'] ?? null) && trim((string) $opt['my']) !== ''
                    ? (string) $opt['my']
                    : (string) ($defOpt['my'] ?? ''),
            ];
        }

        return $merged;
    }

    /**
     * @param  array<string, mixed>  $pkg
     */
    private function marketingServicesLegacyPriceFromRevision(array $pkg): string
    {
        foreach (['revision'] as $key) {
            if (! isset($pkg[$key])) {
                continue;
            }
            $raw = $pkg[$key];
            if (is_array($raw)) {
                $raw = (string) ($raw['en'] ?? $raw['my'] ?? '');
            } else {
                $raw = (string) $raw;
            }
            $digits = preg_replace('/\D+/', '', $raw) ?? '';
            if ($digits !== '' && strlen($digits) <= 15) {
                return number_format((int) $digits);
            }
        }

        return '';
    }

    /**
     * Public site title next to logo, meta titles, admin brand label. Falls back to config('app.name').
     */
    public function displayName(): string
    {
        $name = $this->localized('site_name');

        return $name !== '' ? $name : (string) config('app.name');
    }

    public function logoPublicUrl(): ?string
    {
        return self::publicMediaUrl($this->logo_path);
    }

    /** Filament brand area: uploaded logo URL, or default gradient letter (same idea as public header). */
    public function filamentBrandLogo(): Htmlable|string
    {
        $url = $this->logoPublicUrl();

        return filled($url) ? $url : $this->defaultBrandMarkHtml();
    }

    public function defaultBrandMarkHtml(): Htmlable
    {
        $name = trim($this->displayName());
        $letter = $name !== '' ? mb_substr($name, 0, 1, 'UTF-8') : 'M';

        return new HtmlString(
            '<span class="fi-site-brand-lockup">'
            .'<span class="fi-site-default-logo-mark" aria-hidden="true">'.e($letter).'</span>'
            .'<span class="fi-site-brand-title">'.e($name !== '' ? $name : (string) config('app.name')).'</span>'
            .'</span>'
        );
    }

    public function faviconPublicUrl(): ?string
    {
        return self::publicMediaUrl($this->favicon_path);
    }

    public function heroImageUrl(): string
    {
        $legacyPacked = json_decode((string) $this->hero_image_path, true);
        if (is_array($legacyPacked) && isset($legacyPacked[0]) && is_string($legacyPacked[0])) {
            return self::publicMediaUrl($legacyPacked[0]) ?? asset('images/hero-fallback.svg');
        }

        return self::publicMediaUrl($this->hero_image_path) ?? asset('images/hero-fallback.svg');
    }

    /**
     * @return list<string>
     */
    public function heroImageUrls(int $max = 4): array
    {
        $urls = [];
        $paths = $this->hero_image_paths;
        if (is_string($paths)) {
            $decoded = json_decode($paths, true);
            $paths = is_array($decoded) ? $decoded : [];
        }
        $paths = is_array($paths) ? $paths : [];

        if ($paths === []) {
            $legacyPacked = json_decode((string) $this->hero_image_path, true);
            if (is_array($legacyPacked)) {
                $paths = $legacyPacked;
            }
        }

        foreach ($paths as $path) {
            if (is_array($path)) {
                $path = $path['path'] ?? $path['url'] ?? null;
            }

            if (! is_string($path) || trim($path) === '') {
                continue;
            }

            $url = self::publicMediaUrl($path);
            if ($url !== null) {
                $urls[] = $url;
            }
        }

        if ($urls === [] && filled($this->hero_image_path)) {
            $single = self::publicMediaUrl($this->hero_image_path);
            if ($single !== null) {
                $urls[] = $single;
            }
        }

        $fallback = asset('images/hero-fallback.svg');

        if ($urls === []) {
            $urls[] = $fallback;
        }

        // Keep the 2×2 hero grid filled when only some uploads exist on disk or paths are stale.
        $targetCount = min($max, 4);
        while (count($urls) < $targetCount) {
            $urls[] = $fallback;
        }

        return array_slice(array_values($urls), 0, $max);
    }

    /**
     * Relative path on the `public` disk for the CV served at /cv (by locale).
     */
    public function resolvedCvStoragePath(): ?string
    {
        if (app()->getLocale() === 'my') {
            if (filled($this->cv_pdf_my_path)) {
                return $this->cv_pdf_my_path;
            }
            if (filled($this->cv_pdf_en_path)) {
                return $this->cv_pdf_en_path;
            }

            return null;
        }

        if (filled($this->cv_pdf_en_path)) {
            return $this->cv_pdf_en_path;
        }
        if (filled($this->cv_pdf_my_path)) {
            return $this->cv_pdf_my_path;
        }

        return null;
    }

    public function cvAbsolutePathForDownload(): ?string
    {
        $relative = $this->resolvedCvStoragePath();

        if (! filled($relative)) {
            return null;
        }

        $normalized = ltrim(str_replace('\\', '/', $relative), '/');
        $storage = storage_path('app/public/'.$normalized);

        return is_file($storage) ? $storage : null;
    }

    public function cvDownloadBaseName(): string
    {
        $relative = $this->resolvedCvStoragePath();

        if (filled($relative)) {
            return basename($relative);
        }

        return str_replace([' ', '/'], ['-', '-'], (string) config('app.name')).'-profile.pdf';
    }
}
