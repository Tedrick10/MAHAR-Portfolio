<?php

namespace App\Filament\Resources\ContactMessages\Pages;

use App\Filament\Resources\ContactMessages\ContactMessageResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditContactMessage extends EditRecord
{
    protected static string $resource = ContactMessageResource::class;

    protected function afterFill(): void
    {
        if ($this->record->read_at !== null) {
            return;
        }

        $this->record->update(['read_at' => now()]);
        $this->record->refresh();
        $this->refreshFormData(['read_at']);
    }

    /**
     * @param  array<string, mixed>  $data
     * @return array<string, mixed>
     */
    protected function mutateFormDataBeforeSave(array $data): array
    {
        return array_merge(
            $this->record->only(['name', 'email', 'phone', 'message', 'ip_address']),
            ['read_at' => $data['read_at'] ?? null],
        );
    }

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
