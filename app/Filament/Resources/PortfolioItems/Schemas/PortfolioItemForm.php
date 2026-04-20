<?php

namespace App\Filament\Resources\PortfolioItems\Schemas;

use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class PortfolioItemForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Basics')
                    ->columnSpanFull()
                    ->columns(2)
                    ->schema([
                        TextInput::make('slug')
                            ->label('URL slug')
                            ->columnSpanFull()
                            ->helperText('Leave blank to auto-generate from the English title.'),
                        TextInput::make('title_en')
                            ->label('Title (EN)')
                            ->required(),
                        TextInput::make('title_my')
                            ->label('Title (MY)'),
                        Textarea::make('summary_en')
                            ->label('Summary (EN)')
                            ->rows(4)
                            ->columnSpanFull(),
                        Textarea::make('summary_my')
                            ->label('Summary (MY)')
                            ->rows(4)
                            ->columnSpanFull(),
                    ]),
                Section::make('Media')
                    ->columnSpanFull()
                    ->description('Cover is used on listings and cards. Gallery images appear on the public detail page (lightbox). Leave gallery empty to keep demo placeholder images until you upload your own.')
                    ->schema([
                        FileUpload::make('image_path')
                            ->label('Cover image')
                            ->image()
                            ->disk('public')
                            ->directory('portfolio')
                            ->imageEditor()
                            ->visibility('public')
                            ->columnSpanFull(),
                        FileUpload::make('gallery_paths')
                            ->label('Detail gallery images')
                            ->multiple()
                            ->reorderable()
                            ->appendFiles()
                            ->image()
                            ->disk('public')
                            ->directory('portfolio/gallery')
                            ->imageEditor()
                            ->visibility('public')
                            ->maxFiles(24)
                            ->panelLayout('grid')
                            ->imagePreviewHeight('140')
                            ->helperText('Up to 24 images in a horizontal grid (wraps on smaller screens). Drag tiles to reorder. Shown on the design detail page.'),
                    ]),
                Section::make('Publishing')
                    ->columnSpanFull()
                    ->columns(2)
                    ->schema([
                        TextInput::make('category_en')
                            ->label('Category (EN)'),
                        TextInput::make('category_my')
                            ->label('Category (MY)'),
                        TextInput::make('accent_color')
                            ->label('Accent color (hex)'),
                        TextInput::make('sort_order')
                            ->label('Sort order')
                            ->required()
                            ->numeric()
                            ->default(0),
                        Toggle::make('is_published')
                            ->label('Published')
                            ->required()
                            ->columnSpanFull(),
                    ]),
            ]);
    }
}
