<?php

namespace App\Filament\Resources\WebsiteSettings\Schemas;

use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Tabs\Tab;
use Filament\Support\Icons\Heroicon;

final class WebsiteSettingFormServicesTab
{
    public static function make(): Tab
    {
        return Tab::make('Our services')
            ->icon(Heroicon::OutlinedBuildingStorefront)
            ->schema([
                Section::make('Facebook — Branding packages')
                    ->description('Three cards on the homepage services section. Each package has tier, option/revision lines, and bullet features (EN + MY).')
                    ->columnSpanFull()
                    ->schema([self::facebookBrandingRepeater()])
                    ->collapsible(),
                Section::make('Facebook — Monthly plans')
                    ->description('Three pricing columns with name, price, currency, and feature bullets.')
                    ->columnSpanFull()
                    ->schema([self::facebookMonthlyRepeater()])
                    ->collapsible(),
                Section::make('TikTok — Plan column headers')
                    ->columnSpanFull()
                    ->schema([self::tiktokPlanLabelsRepeater()])
                    ->collapsible(),
                Section::make('TikTok — Comparison rows')
                    ->description('Each row: label (EN/MY) and four cells. Cells: type yes or no, plain text, or "English | Myanmar" for bilingual text.')
                    ->columnSpanFull()
                    ->schema([self::tiktokRowsRepeater()])
                    ->collapsible(),
                Section::make('TikTok — Per-video & totals (MMK)')
                    ->columnSpanFull()
                    ->schema([self::tiktokPricingFields()])
                    ->collapsible(),
                Section::make('TikTok — Footnote')
                    ->columnSpanFull()
                    ->schema([
                        Grid::make(2)->schema([
                            Textarea::make('marketing_services.tiktok.footnote.en')
                                ->label('Footnote (EN)')
                                ->rows(2),
                            Textarea::make('marketing_services.tiktok.footnote.my')
                                ->label('Footnote (MY)')
                                ->rows(2),
                        ]),
                    ]),
            ]);
    }

    private static function facebookBrandingRepeater(): Repeater
    {
        return Repeater::make('marketing_services.facebook.branding')
            ->label('Branding packages')
            ->addActionLabel('Add package')
            ->collapsible()
            ->reorderable()
            ->itemLabel(fn (array $state): ?string => (string) ($state['tier']['en'] ?? $state['tier']['my'] ?? 'Package'))
            ->schema([
                Grid::make(2)->schema([
                    TextInput::make('tier.en')->label('Tier (EN)'),
                    TextInput::make('tier.my')->label('Tier (MY)'),
                    TextInput::make('option.en')->label('Option line (EN)'),
                    TextInput::make('option.my')->label('Option line (MY)'),
                    TextInput::make('revision.en')->label('Revision line (EN)'),
                    TextInput::make('revision.my')->label('Revision line (MY)'),
                ]),
                Repeater::make('items')
                    ->label('Feature bullets')
                    ->addActionLabel('Add bullet')
                    ->reorderable()
                    ->schema([
                        Grid::make(2)->schema([
                            TextInput::make('en')->label('EN'),
                            TextInput::make('my')->label('MY'),
                        ]),
                    ]),
            ]);
    }

    private static function facebookMonthlyRepeater(): Repeater
    {
        return Repeater::make('marketing_services.facebook.monthly')
            ->label('Monthly plans')
            ->addActionLabel('Add plan column')
            ->collapsible()
            ->reorderable()
            ->itemLabel(fn (array $state): ?string => (string) ($state['name']['en'] ?? $state['name']['my'] ?? 'Plan'))
            ->schema([
                Grid::make(2)->schema([
                    TextInput::make('name.en')->label('Name (EN)'),
                    TextInput::make('name.my')->label('Name (MY)'),
                    TextInput::make('price')->label('Price (display)'),
                    TextInput::make('currency')->label('Currency label'),
                ]),
                Repeater::make('features')
                    ->label('Features')
                    ->addActionLabel('Add feature')
                    ->reorderable()
                    ->schema([
                        Grid::make(2)->schema([
                            TextInput::make('en')->label('EN'),
                            TextInput::make('my')->label('MY'),
                        ]),
                    ]),
            ]);
    }

    private static function tiktokPlanLabelsRepeater(): Repeater
    {
        return Repeater::make('marketing_services.tiktok.plan_labels')
            ->label('Plan headers (A–D)')
            ->addActionLabel('Add plan column')
            ->reorderable()
            ->schema([
                Grid::make(2)->schema([
                    TextInput::make('en')->label('EN'),
                    TextInput::make('my')->label('MY'),
                ]),
            ]);
    }

    private static function tiktokRowsRepeater(): Repeater
    {
        return Repeater::make('marketing_services.tiktok.rows')
            ->label('Comparison rows')
            ->addActionLabel('Add row')
            ->collapsible()
            ->reorderable()
            ->schema([
                Grid::make(2)->schema([
                    TextInput::make('label.en')->label('Row label (EN)'),
                    TextInput::make('label.my')->label('Row label (MY)'),
                ]),
                Grid::make(2)->schema([
                    TextInput::make('cells.0')->label('Plan A cell'),
                    TextInput::make('cells.1')->label('Plan B cell'),
                    TextInput::make('cells.2')->label('Plan C cell'),
                    TextInput::make('cells.3')->label('Plan D cell'),
                ]),
            ]);
    }

    private static function tiktokPricingFields(): Grid
    {
        return Grid::make(1)
            ->schema([
                Grid::make(4)->schema([
                    TextInput::make('marketing_services.tiktok.per_video.0')->label('Per video — Plan A'),
                    TextInput::make('marketing_services.tiktok.per_video.1')->label('Per video — Plan B'),
                    TextInput::make('marketing_services.tiktok.per_video.2')->label('Per video — Plan C'),
                    TextInput::make('marketing_services.tiktok.per_video.3')->label('Per video — Plan D'),
                ]),
                Grid::make(4)->schema([
                    TextInput::make('marketing_services.tiktok.totals.0')->label('10 videos total — Plan A'),
                    TextInput::make('marketing_services.tiktok.totals.1')->label('Plan B'),
                    TextInput::make('marketing_services.tiktok.totals.2')->label('Plan C'),
                    TextInput::make('marketing_services.tiktok.totals.3')->label('Plan D'),
                ]),
            ]);
    }
}
