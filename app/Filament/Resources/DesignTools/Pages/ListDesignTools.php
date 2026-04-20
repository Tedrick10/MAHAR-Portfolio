<?php

namespace App\Filament\Resources\DesignTools\Pages;

use App\Filament\Resources\DesignTools\DesignToolResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListDesignTools extends ListRecords
{
    protected static string $resource = DesignToolResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
