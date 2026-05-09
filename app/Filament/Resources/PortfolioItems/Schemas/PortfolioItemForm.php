<?php

namespace App\Filament\Resources\PortfolioItems\Schemas;

use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Illuminate\Support\Str;

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
                    ->description('Cover is used on listings and cards. Add images, paste a YouTube URL, or upload an MP4/WebM for the public detail gallery. Drag rows to reorder. If you set YOUTUBE_API_KEY in .env, the panel will block YouTube links that cannot be embedded (common for major-label music). For those, use “Video upload” instead — that always plays on the site.')
                    ->schema([
                        FileUpload::make('image_path')
                            ->label('Cover image')
                            ->image()
                            ->disk('public')
                            ->directory('portfolio')
                            ->imageEditor()
                            ->visibility('public')
                            ->columnSpanFull(),
                        Repeater::make('detail_media')
                            ->label('Detail gallery')
                            ->addActionLabel('Add image, video, or YouTube')
                            ->reorderable()
                            ->collapsible()
                            ->itemLabel(function (?array $state): ?string {
                                if (! is_array($state)) {
                                    return null;
                                }

                                return match ($state['type'] ?? 'image') {
                                    'youtube' => 'YouTube: '.Str::limit((string) ($state['youtube_url'] ?? ''), 42),
                                    'video' => 'Uploaded video',
                                    default => 'Image',
                                };
                            })
                            ->schema([
                                Select::make('type')
                                    ->label('Type')
                                    ->options([
                                        'image' => 'Image upload',
                                        'youtube' => 'YouTube link',
                                        'video' => 'Video upload (MP4 / WebM)',
                                    ])
                                    ->default('image')
                                    ->required()
                                    ->live(),
                                FileUpload::make('gallery_image')
                                    ->label('Image file')
                                    ->visible(fn ($get) => ($get('type') ?? 'image') === 'image')
                                    ->image()
                                    ->disk('public')
                                    ->directory('portfolio/gallery')
                                    ->imageEditor()
                                    ->visibility('public'),
                                TextInput::make('youtube_url')
                                    ->label('YouTube URL')
                                    ->visible(fn ($get) => ($get('type')) === 'youtube')
                                    ->placeholder('https://www.youtube.com/watch?v=…')
                                    ->url(),
                                FileUpload::make('video_path')
                                    ->label('Video files')
                                    ->visible(fn ($get) => ($get('type')) === 'video')
                                    ->required(fn ($get) => ($get('type')) === 'video')
                                    ->multiple()
                                    ->reorderable()
                                    ->appendFiles()
                                    ->disk('public')
                                    ->directory('portfolio/videos')
                                    ->visibility('public')
                                    ->acceptedFileTypes(['video/*'])
                                    ->maxParallelUploads(1)
                                    ->panelLayout('grid')
                                    ->imagePreviewHeight('140')
                                    ->itemPanelAspectRatio('4:5')
                                    ->extraAttributes(['class' => 'portfolio-video-grid-upload']),
                            ])
                            ->columnSpanFull(),
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
