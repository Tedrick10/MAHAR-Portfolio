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

    private static ?self $cached = null;

    public static function current(): self
    {
        if (self::$cached instanceof self) {
            return self::$cached;
        }

        self::$cached = self::query()->first() ?? self::query()->create([]);

        return self::$cached;
    }

    public static function forgetCached(): void
    {
        self::$cached = null;
    }

    protected static function booted(): void
    {
        static::saved(fn () => self::forgetCached());
    }

    protected function casts(): array
    {
        return [
            'marketing_services' => 'array',
        ];
    }

    /**
     * Homepage “Our services” block (Facebook + TikTok). Uses the database JSON when set; otherwise config defaults.
     *
     * @return array<string, mixed>
     */
    public function marketingServicesResolved(): array
    {
        $defaults = config('marketing_services', []);
        $stored = $this->marketing_services;

        if (! is_array($stored) || $stored === []) {
            return $defaults;
        }

        return $stored;
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
        return self::publicMediaUrl($this->hero_image_path) ?? asset('images/hero-designer.jpg');
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
