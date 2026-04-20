<?php

namespace App\Filament\Resources\WebsiteSettings\Tables;

use Filament\Actions\EditAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class WebsiteSettingsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                ImageColumn::make('logo_path')
                    ->label('Logo')
                    ->disk('public')
                    ->height(40)
                    ->defaultImageUrl(null),
                TextColumn::make('hero_title_en')
                    ->label('Hero title (EN)')
                    ->searchable()
                    ->limit(50),
                TextColumn::make('contact_email')
                    ->label('Contact email')
                    ->searchable()
                    ->copyable(),
                IconColumn::make('favicon_path')
                    ->label('Favicon')
                    ->boolean()
                    ->trueIcon('heroicon-o-check-circle')
                    ->falseIcon('heroicon-o-minus-circle')
                    ->getStateUsing(fn ($record) => filled($record->favicon_path)),
                TextColumn::make('updated_at')
                    ->label('Last updated')
                    ->dateTime()
                    ->sortable(),
            ])
            ->filters([
                //
            ])
            ->recordActions([
                EditAction::make(),
            ])
            ->toolbarActions([]);
    }
}
