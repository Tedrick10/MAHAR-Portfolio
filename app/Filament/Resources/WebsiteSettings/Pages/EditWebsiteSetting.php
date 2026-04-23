<?php

namespace App\Filament\Resources\WebsiteSettings\Pages;

use App\Filament\Resources\WebsiteSettings\WebsiteSettingResource;
use App\Support\MarketingServicesCellCodec;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Support\Facades\Schema;

class EditWebsiteSetting extends EditRecord
{
    protected static string $resource = WebsiteSettingResource::class;

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

        return $data;
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

        $heroImages = $this->normalizeHeroPaths($data['hero_image_paths'] ?? null);
        if (! Schema::hasColumn('website_settings', 'hero_image_paths')) {
            unset($data['hero_image_paths']);
            // Backward-compatible storage when the new JSON column is not migrated yet.
            $data['hero_image_path'] = $heroImages !== [] ? json_encode($heroImages, JSON_UNESCAPED_SLASHES) : null;
        } else {
            $data['hero_image_path'] = $heroImages[0] ?? null;
            $data['hero_image_paths'] = $heroImages;
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
