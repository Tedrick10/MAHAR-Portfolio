<?php

namespace App\Filament\Resources\WebsiteSettings\Pages;

use App\Filament\Resources\WebsiteSettings\WebsiteSettingResource;
use App\Support\MarketingServicesCellCodec;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Support\Facades\Schema;

class EditWebsiteSetting extends EditRecord
{
    protected static string $resource = WebsiteSettingResource::class;

    /** @var list<string> Lang keys under `site.*` matching `website_settings` columns without `_en` / `_my`. */
    private const SERVICES_COPY_PREFIXES = [
        'services_lab_kicker',
        'services_heading',
        'services_intro',
        'services_cta_contact',
        'services_facebook_kicker',
        'services_facebook_title',
        'services_fb_branding_heading',
        'services_fb_monthly_heading',
        'services_package_script',
        'services_tiktok_kicker',
        'services_tiktok_title',
        'services_tiktok_subtitle',
        'services_tiktok_col_detail',
        'services_tiktok_row_per_video',
        'services_tiktok_row_total',
        'services_download_pdf',
    ];

    protected function mutateFormDataBeforeFill(array $data): array
    {
        $resolved = $this->getRecord()->marketingServicesResolved();

        if (isset($resolved['tiktok']['rows']) && is_array($resolved['tiktok']['rows'])) {
            $resolved['tiktok']['rows'] = MarketingServicesCellCodec::flattenTiktokRows($resolved['tiktok']['rows']);
        }

        $data['marketing_services'] = $resolved;

        if (
            (! isset($data['hero_image_paths']) || ! is_array($data['hero_image_paths']) || $data['hero_image_paths'] === []) &&
            filled($data['hero_image_path'] ?? null)
        ) {
            $legacy = json_decode((string) $data['hero_image_path'], true);
            $data['hero_image_paths'] = is_array($legacy) ? $legacy : [$data['hero_image_path']];
        }

        return $this->mergeServicesCopyDefaultsForForm($data);
    }

    /**
     * Show the same EN/MY strings as the public site when DB columns are still empty.
     *
     * @param  array<string, mixed>  $data
     * @return array<string, mixed>
     */
    private function mergeServicesCopyDefaultsForForm(array $data): array
    {
        if (! Schema::hasColumn('website_settings', 'services_heading_en')) {
            return $data;
        }

        foreach (self::SERVICES_COPY_PREFIXES as $prefix) {
            $key = 'site.'.$prefix;
            $enCol = $prefix.'_en';
            $myCol = $prefix.'_my';
            if (! filled($data[$enCol] ?? null)) {
                $data[$enCol] = $this->translationLine($key, 'en');
            }
            if (! filled($data[$myCol] ?? null)) {
                $data[$myCol] = $this->translationLine($key, 'my');
            }
        }

        return $data;
    }

    private function translationLine(string $key, string $locale): string
    {
        $value = trans($key, [], $locale);

        return is_string($value) ? $value : '';
    }

    /**
     * @param  array<string, mixed>  $data
     * @return array<string, mixed>
     */
    protected function mutateFormDataBeforeSave(array $data): array
    {
        if (
            isset($data['marketing_services']['tiktok']['rows']) &&
            is_array($data['marketing_services']['tiktok']['rows'])
        ) {
            $data['marketing_services']['tiktok']['rows'] = MarketingServicesCellCodec::expandTiktokRows(
                $data['marketing_services']['tiktok']['rows'],
            );
        }

        if (
            isset($data['marketing_services']['facebook']['branding']) &&
            is_array($data['marketing_services']['facebook']['branding'])
        ) {
            foreach ($data['marketing_services']['facebook']['branding'] as $idx => $pkg) {
                if (! is_array($pkg)) {
                    continue;
                }
                unset($data['marketing_services']['facebook']['branding'][$idx]['revision']);
            }
        }

        $heroImages = $this->normalizeHeroPaths($data['hero_image_paths'] ?? null);
        if (! Schema::hasColumn('website_settings', 'hero_image_paths')) {
            unset($data['hero_image_paths']);
            // Backward-compatible storage when the new JSON column is not migrated yet.
            $data['hero_image_path'] = $heroImages !== [] ? json_encode($heroImages, JSON_UNESCAPED_SLASHES) : null;
        } else {
            $data['hero_image_path'] = $heroImages[0] ?? null;
            $data['hero_image_paths'] = $heroImages;
        }

        return $this->dropAttributesWithoutDbColumns($data);
    }

    /**
     * Avoid SQL errors when production DB is missing newer columns (migration not run yet).
     *
     * @param  array<string, mixed>  $data
     * @return array<string, mixed>
     */
    private function dropAttributesWithoutDbColumns(array $data): array
    {
        if (! Schema::hasTable('website_settings')) {
            return $data;
        }

        /** @var list<string> $columns */
        $columns = Schema::getColumnListing('website_settings');

        foreach (array_keys($data) as $key) {
            if (! in_array($key, $columns, true)) {
                unset($data[$key]);
            }
        }

        return $data;
    }

    /**
     * @return list<string>
     */
    private function normalizeHeroPaths(mixed $raw): array
    {
        $paths = [];

        if (is_array($raw)) {
            foreach ($raw as $item) {
                if (is_string($item) && trim($item) !== '') {
                    $paths[] = trim($item);
                    continue;
                }

                if (is_array($item)) {
                    $candidate = $item['path'] ?? $item['url'] ?? null;
                    if (is_string($candidate) && trim($candidate) !== '') {
                        $paths[] = trim($candidate);
                    }
                }
            }
        }

        return array_values(array_slice(array_unique($paths), 0, 4));
    }
}
