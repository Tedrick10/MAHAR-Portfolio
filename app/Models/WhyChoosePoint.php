<?php

namespace App\Models;

use App\Models\Concerns\HasLocalizedColumns;
use App\Models\Concerns\ResolvesPublicMediaUrl;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WhyChoosePoint extends Model
{
    use HasFactory;
    use HasLocalizedColumns;
    use ResolvesPublicMediaUrl;

    protected $fillable = [
        'title_en',
        'title_my',
        'body_en',
        'body_my',
        'icon',
        'icon_external_url',
        'icon_image_path',
        'sort_order',
        'is_published',
    ];

    protected function casts(): array
    {
        return [
            'is_published' => 'boolean',
            'sort_order' => 'integer',
        ];
    }

    public function scopePublished($query)
    {
        return $query->where('is_published', true)->orderBy('sort_order');
    }

    public function iconDisplayUrl(): ?string
    {
        if (filled($this->icon_external_url)) {
            return trim($this->icon_external_url);
        }

        return self::publicMediaUrl($this->icon_image_path);
    }
}
