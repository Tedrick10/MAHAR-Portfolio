<?php

namespace App\Models;

use App\Models\Concerns\HasLocalizedColumns;
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
     * Detail page gallery: uploaded images first; if none, demo placeholders.
     *
     * @return list<string>
     */
    public function detailGalleryUrls(): array
    {
        $paths = is_array($this->gallery_paths) ? $this->gallery_paths : [];

        $urls = [];
        foreach ($paths as $path) {
            if (! is_string($path) || trim($path) === '') {
                continue;
            }
            $url = self::publicMediaUrl($path);
            if ($url !== null) {
                $urls[] = $url;
            }
        }

        if ($urls !== []) {
            return array_values(array_unique($urls));
        }

        return $this->detailGalleryDemoUrls();
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
