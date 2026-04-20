<?php

namespace App\Filament\Resources\PortfolioItems\Tables;

use App\Models\PortfolioItem;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class PortfolioItemsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('slug')
                    ->searchable(),
                TextColumn::make('title_en')
                    ->searchable(),
                TextColumn::make('title_my')
                    ->searchable(),
                ImageColumn::make('image_path')
                    ->label('Cover')
                    ->disk('public')
                    ->height(48),
                TextColumn::make('gallery_paths')
                    ->label('Gallery')
                    ->formatStateUsing(fn (?array $state): string => $state ? (string) count(array_filter($state)) : '0')
                    ->alignCenter(),
                TextColumn::make('category_en')
                    ->searchable(),
                TextColumn::make('category_my')
                    ->searchable(),
                TextColumn::make('accent_color')
                    ->searchable(),
                TextColumn::make('sort_order')
                    ->numeric()
                    ->sortable(),
                IconColumn::make('is_published')
                    ->boolean(),
                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->recordActions([
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
