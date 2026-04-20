<?php

namespace App\Filament\Resources\Partners\Schemas;

use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class PartnerForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name_en')
                    ->required(),
                TextInput::make('name_my'),
                Section::make('Logo')
                    ->description('Logo URL is used when set; otherwise the uploaded image file is shown.')
                    ->schema([
                        Grid::make(2)->schema([
                            TextInput::make('logo_external_url')
                                ->label('Logo image URL')
                                ->url()
                                ->maxLength(2048),
                            FileUpload::make('logo_path')
                                ->label('Or upload logo')
                                ->image()
                                ->disk('public')
                                ->directory('partners')
                                ->imageEditor()
                                ->visibility('public')
                                ->maxSize(2048),
                        ]),
                    ]),
                TextInput::make('website_url')
                    ->url(),
                TextInput::make('sort_order')
                    ->required()
                    ->numeric()
                    ->default(0),
                Toggle::make('is_published')
                    ->required(),
            ]);
    }
}
