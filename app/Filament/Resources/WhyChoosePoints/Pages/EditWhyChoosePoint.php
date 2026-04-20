<?php

namespace App\Filament\Resources\WhyChoosePoints\Pages;

use App\Filament\Resources\WhyChoosePoints\WhyChoosePointResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditWhyChoosePoint extends EditRecord
{
    protected static string $resource = WhyChoosePointResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
