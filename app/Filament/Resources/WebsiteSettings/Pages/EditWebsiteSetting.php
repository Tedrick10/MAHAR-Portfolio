<?php

namespace App\Filament\Resources\WebsiteSettings\Pages;

use App\Filament\Resources\WebsiteSettings\WebsiteSettingResource;
use App\Support\MarketingServicesCellCodec;
use Filament\Resources\Pages\EditRecord;

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

        return $data;
    }
}
