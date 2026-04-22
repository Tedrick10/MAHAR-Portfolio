<?php

namespace App\Models;

use App\Models\Concerns\HasLocalizedColumns;
use App\Models\Concerns\ResolvesPublicMediaUrl;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DesignTool extends Model
{
    use HasFactory;
    use HasLocalizedColumns;
    use ResolvesPublicMediaUrl;

    protected $fillable = [
        'name_en',
        'name_my',
        'category_en',
        'category_my',
        'logo_path',
        'logo_external_url',
        'website_url',
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

    public function logoImageUrl(): ?string
    {
        if (filled($this->logo_external_url)) {
            return trim($this->logo_external_url);
        }

        return self::publicMediaUrl($this->logo_path);
    }
}
