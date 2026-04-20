<?php

namespace App\Filament\Resources\DesignTools;

use App\Filament\Resources\DesignTools\Pages\CreateDesignTool;
use App\Filament\Resources\DesignTools\Pages\EditDesignTool;
use App\Filament\Resources\DesignTools\Pages\ListDesignTools;
use App\Filament\Resources\DesignTools\Schemas\DesignToolForm;
use App\Filament\Resources\DesignTools\Tables\DesignToolsTable;
use App\Models\DesignTool;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class DesignToolResource extends Resource
{
    protected static ?string $model = DesignTool::class;

    protected static ?string $navigationLabel = 'Design tools';

    protected static ?int $navigationSort = 15;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedPaintBrush;

    public static function form(Schema $schema): Schema
    {
        return DesignToolForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return DesignToolsTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListDesignTools::route('/'),
            'create' => CreateDesignTool::route('/create'),
            'edit' => EditDesignTool::route('/{record}/edit'),
        ];
    }
}
