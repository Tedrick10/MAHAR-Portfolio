<?php

namespace App\Filament\Resources\ContactMessages\Schemas;

use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class ContactMessageForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->disabled(),
                TextInput::make('email')
                    ->label('Email address')
                    ->disabled(),
                TextInput::make('phone')
                    ->disabled(),
                Textarea::make('message')
                    ->disabled()
                    ->columnSpanFull(),
                TextInput::make('ip_address')
                    ->disabled(),
                DateTimePicker::make('read_at')
                    ->label('Read at (mark handled)'),
            ]);
    }
}
