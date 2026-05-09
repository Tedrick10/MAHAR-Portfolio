<?php

namespace App\Models;

use App\Models\Concerns\HasLocalizedColumns;
use App\Support\YoutubeEmbed;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class PortfolioItem extends Model
{
    use Concerns\ResolvesPublicMediaUrl;
    use HasFactory;
    use HasLocalizedColumns;

    protected $fillable = [
        'slug',
        'title_en',
        'title_my',
        'summary_en',
        'summary_my',
        'image_path',
        'gallery_paths',
        'detail_media',
        'category_en',
        'category_my',
        'accent_color',
        'sort_order',
        'is_published',
    ];

    protected function casts(): array
    {
        return [
            'gallery_paths' => 'array',
            'detail_media' => 'array',
            'is_published' => 'boolean',
            'sort_order' => 'integer',
        ];
    }

    protected static function booted(): void
    {
        static::saving(function (PortfolioItem $item): void {
            if (! filled($item->slug)) {
                $item->slug = Str::slug($item->title_en).'-'.Str::lower(Str::random(4));
            } else {
                $item->slug = Str::slug($item->slug);
            }

            if (is_array($item->detail_media)) {
                $normalized = [];
                $videoPaths = [];
                foreach ($item->detail_media as $row) {
                    if (! is_array($row)) {
                        continue;
                    }
                    $type = $row['type'] ?? 'image';
                    if ($type === 'youtube') {
                        $u = trim((string) ($row['youtube_url'] ?? $row['url'] ?? ''));
                        if ($u !== '') {
                            $normalized[] = ['type' => 'youtube', 'url' => $u];
                        }
                    } elseif ($type === 'video') {
                        $paths = $row['video_path'] ?? $row['paths'] ?? $row['path'] ?? null;
                        $paths = is_array($paths) ? $paths : [$paths];

                        foreach ($paths as $p) {
                            if (! filled($p)) {
                                continue;
                            }

                            $videoPaths[] = $p;
                        }
                    } else {
                        $p = $row['gallery_image'] ?? $row['image_path'] ?? $row['path'] ?? null;
                        if (filled($p)) {
                            $normalized[] = ['type' => 'image', 'path' => $p];
                        }
                    }
                }

                if ($videoPaths !== []) {
                    $normalized[] = ['type' => 'video', 'paths' => array_values(array_unique($videoPaths))];
                }
                $item->detail_media = $normalized;

                $imagePaths = [];
                foreach ($normalized as $block) {
                    if (($block['type'] ?? '') === 'image' && filled($block['path'] ?? null)) {
                        $imagePaths[] = $block['path'];
                    }
                }
                $item->gallery_paths = $imagePaths;
            }
        });
    }

    public function scopePublished($query)
    {
        return $query->where('is_published', true)->orderBy('sort_order');
    }

    public function coverImageUrl(): ?string
    {
        return self::publicMediaUrl($this->image_path);
    }

    /**
     * Raw rows: detail_media JSON, else legacy gallery_paths as image-only rows.
     *
     * @return list<array{type: string, path?: string, url?: string}>
     */
    private function rawDetailMediaRows(): array
    {
        $dm = $this->detail_media;
        if (is_array($dm) && $dm !== []) {
            return array_values(array_filter($dm, 'is_array'));
        }

        $paths = is_array($this->gallery_paths) ? $this->gallery_paths : [];
        $rows = [];
        foreach ($paths as $path) {
            if (! is_string($path) || trim($path) === '') {
                continue;
            }
            $rows[] = ['type' => 'image', 'path' => $path];
        }

        return $rows;
    }

    /**
     * Blocks for the public detail page: images, YouTube embeds, or uploaded video files.
     *
     * @return list<array<string, mixed>>
     */
    public function resolvedDetailMedia(): array
    {
        $rows = $this->rawDetailMediaRows();
        $out = [];
        foreach ($rows as $row) {
            $type = $row['type'] ?? 'image';
            if ($type === 'youtube') {
                $url = trim((string) ($row['url'] ?? ''));
                $id = YoutubeEmbed::videoIdFromUrl($url);
                if ($id !== null) {
                    $out[] = [
                        'kind' => 'youtube',
                        'video_id' => $id,
                        'thumbnail_url' => 'https://i.ytimg.com/vi/'.$id.'/hqdefault.jpg',
                    ];
                }
            } elseif ($type === 'video') {
                $paths = $row['paths'] ?? $row['path'] ?? null;
                $paths = is_array($paths) ? $paths : [$paths];

                foreach ($paths as $path) {
                    $mediaUrl = self::publicMediaUrl(is_string($path) ? $path : null);
                    if ($mediaUrl !== null) {
                        $out[] = ['kind' => 'video', 'url' => $mediaUrl];
                    }
                }
            } else {
                $path = $row['path'] ?? '';
                $mediaUrl = self::publicMediaUrl($path);
                if ($mediaUrl !== null) {
                    $out[] = ['kind' => 'image', 'url' => $mediaUrl];
                }
            }
        }

        if ($out !== []) {
            return $out;
        }

        return array_map(
            fn (string $url) => ['kind' => 'image', 'url' => $url],
            $this->detailGalleryDemoUrls()
        );
    }

    /**
     * Detail page gallery: uploaded images first; if none, demo placeholders.
     *
     * @return list<string>
     */
    public function detailGalleryUrls(): array
    {
        $urls = [];
        foreach ($this->resolvedDetailMedia() as $block) {
            if (($block['kind'] ?? '') === 'image' && isset($block['url'])) {
                $urls[] = $block['url'];
            }
        }

        return $urls;
    }

    /**
     * Public demo gallery paths. The detail view uses fixed 4:3 cells with object-cover,
     * so assets may be any aspect ratio; prefer sharp sources at least ~800×600 for clarity.
     *
     * @return list<string>
     */
    public function detailGalleryDemoUrls(): array
    {
        $paths = [
            'demo-portfolio-detail/1.jpg',
            'demo-portfolio-detail/2.jpg',
            'demo-portfolio-detail/3.jpg',
            'demo-portfolio-detail/4.jpg',
            'demo-portfolio-detail/5.jpg',
            'demo-portfolio-detail/6.jpg',
            'demo-portfolio-detail/7.jpg',
            'demo-portfolio-detail/8.jpg',
            'demo-portfolio-detail/9.jpg',
        ];

        return array_values(array_filter(array_map(
            fn (string $path) => self::publicMediaUrl($path),
            $paths
        )));
    }
}
