<?php

namespace App\Models;

use App\Models\Concerns\HasLocalizedColumns;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

#[Fillable([
    'question_en',
    'question_my',
    'answer_en',
    'answer_my',
    'sort_order',
    'is_published',
])]
class Faq extends Model
{
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
}
