<?php

namespace App\Filament\Resources\WhyChoosePoints;

use App\Filament\Resources\WhyChoosePoints\Pages\CreateWhyChoosePoint;
use App\Filament\Resources\WhyChoosePoints\Pages\EditWhyChoosePoint;
use App\Filament\Resources\WhyChoosePoints\Pages\ListWhyChoosePoints;
use App\Filament\Resources\WhyChoosePoints\Schemas\WhyChoosePointForm;
use App\Filament\Resources\WhyChoosePoints\Tables\WhyChoosePointsTable;
use App\Models\WhyChoosePoint;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class WhyChoosePointResource extends Resource
{
    protected static ?string $model = WhyChoosePoint::class;

    protected static ?string $navigationLabel = 'Why choose us';

    protected static ?int $navigationSort = 14;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedSparkles;

    public static function form(Schema $schema): Schema
    {
        return WhyChoosePointForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return WhyChoosePointsTable::configure($table);
    }

    public static function getPages(): array
    {
        return [
            'index' => ListWhyChoosePoints::route('/'),
            'create' => CreateWhyChoosePoint::route('/create'),
            'edit' => EditWhyChoosePoint::route('/{record}/edit'),
        ];
    }
}
