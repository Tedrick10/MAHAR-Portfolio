<?php

namespace App\Filament\Resources\CustomerReviews\Schemas;

use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class CustomerReviewForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('author_en')
                    ->label('Name (English)')
                    ->required()
                    ->maxLength(120),
                TextInput::make('author_my')
                    ->label('Name (Myanmar)')
                    ->maxLength(120),
                TextInput::make('role_en')
                    ->label('Role / company (English)')
                    ->maxLength(160),
                TextInput::make('role_my')
                    ->label('Role / company (Myanmar)')
                    ->maxLength(160),
                Textarea::make('body_en')
                    ->label('Review (English)')
                    ->required()
                    ->rows(4)
                    ->columnSpanFull(),
                Textarea::make('body_my')
                    ->label('Review (Myanmar)')
                    ->rows(4)
                    ->columnSpanFull(),
                TextInput::make('rating')
                    ->label('Stars (1–5)')
                    ->required()
                    ->numeric()
                    ->minValue(1)
                    ->maxValue(5)
                    ->default(5),
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
