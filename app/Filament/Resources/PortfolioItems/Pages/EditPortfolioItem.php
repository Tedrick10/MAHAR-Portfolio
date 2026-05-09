<?php

namespace App\Filament\Resources\PortfolioItems\Pages;

use App\Filament\Resources\PortfolioItems\PortfolioItemResource;
use App\Support\PortfolioYoutubeEmbeddability;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditPortfolioItem extends EditRecord
{
    protected static string $resource = PortfolioItemResource::class;

    protected function mutateFormDataBeforeSave(array $data): array
    {
        PortfolioYoutubeEmbeddability::assertDetailMediaYoutubeEmbeddable($data);

        return $data;
    }

    protected function mutateFormDataBeforeFill(array $data): array
    {
        $record = $this->getRecord();
        $dm = $record->detail_media;
        if ((! is_array($dm) || $dm === []) && is_array($record->gallery_paths) && $record->gallery_paths !== []) {
            $dm = array_map(fn (string $p): array => ['type' => 'image', 'path' => $p], $record->gallery_paths);
        }

        if (is_array($dm) && $dm !== []) {
            $videoPaths = [];
            $mapped = [];

            foreach ($dm as $row) {
                if (! is_array($row)) {
                    continue;
                }

                if (($row['type'] ?? 'image') === 'video') {
                    $paths = $row['paths'] ?? $row['path'] ?? null;
                    $paths = is_array($paths) ? $paths : [$paths];
                    foreach ($paths as $path) {
                        if (filled($path)) {
                            $videoPaths[] = $path;
                        }
                    }

                    continue;
                }

                $mapped[] = match ($row['type'] ?? 'image') {
                    'youtube' => [
                        'type' => 'youtube',
                        'youtube_url' => $row['url'] ?? '',
                    ],
                    default => [
                        'type' => 'image',
                        'gallery_image' => $row['path'] ?? '',
                    ],
                };
            }

            if ($videoPaths !== []) {
                $mapped[] = [
                    'type' => 'video',
                    'video_path' => array_values(array_unique($videoPaths)),
                ];
            }

            $data['detail_media'] = $mapped;
        }

        return $data;
    }

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
