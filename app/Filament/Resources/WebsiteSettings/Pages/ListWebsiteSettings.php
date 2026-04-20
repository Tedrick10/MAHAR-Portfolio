<?php

namespace App\Filament\Resources\WebsiteSettings\Pages;

use App\Filament\Resources\WebsiteSettings\WebsiteSettingResource;
use App\Models\WebsiteSetting;
use Filament\Resources\Pages\ListRecords;

class ListWebsiteSettings extends ListRecords
{
    protected static string $resource = WebsiteSettingResource::class;

    public function mount(): void
    {
        $record = WebsiteSetting::query()->first() ?? WebsiteSetting::query()->create([]);

        $this->redirect(WebsiteSettingResource::getUrl('edit', ['record' => $record]));
    }
}
