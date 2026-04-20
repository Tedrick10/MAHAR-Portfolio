<?php

namespace App\Filament\Resources\WhyChoosePoints\Schemas;

use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class WhyChoosePointForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('title_en')
                    ->label('Title (English)')
                    ->required()
                    ->maxLength(160),
                TextInput::make('title_my')
                    ->label('Title (Myanmar)')
                    ->maxLength(160),
                Textarea::make('body_en')
                    ->label('Description (English)')
                    ->required()
                    ->rows(3)
                    ->columnSpanFull(),
                Textarea::make('body_my')
                    ->label('Description (Myanmar)')
                    ->rows(3)
                    ->columnSpanFull(),
                Section::make('Icon')
                    ->description('Optional image or URL replaces the decorative homepage icon. Otherwise use an emoji, or leave both empty for a built-in graphic.')
                    ->schema([
                        Grid::make(2)->schema([
                            TextInput::make('icon_external_url')
                                ->label('Icon image URL')
                                ->url()
                                ->maxLength(2048),
                            FileUpload::make('icon_image_path')
                                ->label('Or upload icon')
                                ->image()
                                ->disk('public')
                                ->directory('why-choose-icons')
                                ->visibility('public')
                                ->maxSize(1024),
                        ]),
                        TextInput::make('icon')
                            ->label('Emoji / symbol (optional)')
                            ->maxLength(12)
                            ->placeholder('✦')
                            ->helperText('Shown in a badge when no image URL or file is set.'),
                    ]),
                TextInput::make('sort_order')
                    ->required()
                    ->numeric()
                    ->default(0),
                Toggle::make('is_published')
                    ->label('Published on home')
                    ->default(true),
            ]);
    }
}
