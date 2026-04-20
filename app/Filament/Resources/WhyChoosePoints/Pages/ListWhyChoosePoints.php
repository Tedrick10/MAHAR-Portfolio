<?php

namespace App\Filament\Resources\WhyChoosePoints\Pages;

use App\Filament\Resources\WhyChoosePoints\WhyChoosePointResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListWhyChoosePoints extends ListRecords
{
    protected static string $resource = WhyChoosePointResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
