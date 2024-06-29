<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Article extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'document_path',
        'user_id'
    ];

    public const ARTICLE_PATH = 'articles';

    public function author(): BelongsTo {
        return $this->belongsTo(User::class, 'user_id');
    }
}
