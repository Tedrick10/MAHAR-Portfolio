<?php

namespace App\Filament\Resources\CustomerReviews\Pages;

use App\Filament\Resources\CustomerReviews\CustomerReviewResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditCustomerReview extends EditRecord
{
    protected static string $resource = CustomerReviewResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
