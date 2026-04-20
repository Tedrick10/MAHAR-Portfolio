<?php

namespace App\Models;

use App\Models\Concerns\HasLocalizedColumns;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

#[Fillable([
    'author_en',
    'author_my',
    'role_en',
    'role_my',
    'body_en',
    'body_my',
    'rating',
    'sort_order',
    'is_published',
])]
class CustomerReview extends Model
{
    use HasFactory;
    use HasLocalizedColumns;

    protected function casts(): array
    {
        return [
            'is_published' => 'boolean',
            'sort_order' => 'integer',
            'rating' => 'integer',
        ];
    }

    public function scopePublished($query)
    {
        return $query->where('is_published', true)->orderBy('sort_order');
    }
}
