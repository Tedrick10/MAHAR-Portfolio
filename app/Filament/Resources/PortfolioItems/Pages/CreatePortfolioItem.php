<?php

namespace App\Filament\Resources\PortfolioItems\Pages;

use App\Filament\Resources\PortfolioItems\PortfolioItemResource;
use App\Support\PortfolioYoutubeEmbeddability;
use Filament\Resources\Pages\CreateRecord;

class CreatePortfolioItem extends CreateRecord
{
    protected static string $resource = PortfolioItemResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        PortfolioYoutubeEmbeddability::assertDetailMediaYoutubeEmbeddable($data);

        return $data;
    }
}
