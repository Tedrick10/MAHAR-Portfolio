<?php

namespace App\Filament\Resources\DesignTools\Schemas;

use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class DesignToolForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name_en')
                    ->label('Name (English)')
                    ->required()
                    ->maxLength(120),
                TextInput::make('name_my')
                    ->label('Name (Myanmar)')
                    ->maxLength(120),
                TextInput::make('category_en')
                    ->label('Category (English)')
                    ->placeholder('e.g. UI · Prototyping')
                    ->maxLength(120),
                TextInput::make('category_my')
                    ->label('Category (Myanmar)')
                    ->maxLength(120),
                Section::make('Logo')
                    ->description('If you set a logo URL, it is shown first. Otherwise the uploaded file (or an older path stored in the database) is used.')
                    ->schema([
                        Grid::make(2)->schema([
                            TextInput::make('logo_external_url')
                                ->label('Logo image URL')
                                ->url()
                                ->maxLength(2048)
                                ->helperText('Direct link to PNG, JPG, SVG, or WebP (e.g. CDN).'),
                            FileUpload::make('logo_path')
                                ->label('Or upload logo')
                                ->image()
                                ->disk('public')
                                ->directory('design-tools')
                                ->imageEditor()
                                ->visibility('public')
                                ->maxSize(2048),
                        ]),
                    ]),
                TextInput::make('website_url')
                    ->label('Official website')
                    ->url()
                    ->nullable()
                    ->maxLength(500),
                TextInput::make('sort_order')
                    ->required()
                    ->numeric()
                    ->default(0),
                Toggle::make('is_published')
                    ->label('Published on site')
                    ->default(true),
            ]);
    }
}
