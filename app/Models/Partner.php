<?php

namespace App\Models;

use App\Models\Concerns\HasLocalizedColumns;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

#[Fillable([
    'name_en',
    'name_my',
    'logo_path',
    'logo_external_url',
    'website_url',
    'sort_order',
    'is_published',
])]
class Partner extends Model
{
    use Concerns\ResolvesPublicMediaUrl;
    use HasFactory;
    use HasLocalizedColumns;

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
