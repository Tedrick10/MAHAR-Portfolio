<?php

namespace App\Filament\Resources\DesignTools\Pages;

use App\Filament\Resources\DesignTools\DesignToolResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditDesignTool extends EditRecord
{
    protected static string $resource = DesignToolResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
