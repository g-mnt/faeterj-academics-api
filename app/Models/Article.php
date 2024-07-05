<?php

namespace App\Models;

use App\ArticleStatusesEnum;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Storage;

class Article extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'document_path',
        'status',
        'user_id'
    ];

    protected $casts =[
        'status' => ArticleStatusesEnum::class
    ];

    public const ARTICLE_PATH = 'articles';

    public function author(): BelongsTo {
        return $this->belongsTo(User::class, 'user_id');
    }

    protected function documentUrl(): Attribute {
        return Attribute::make(
            get: fn (mixed $value, array $attributes) => Storage::temporaryUrl($attributes['document_path'], now()->addDay())
        )->shouldCache();
    }
}
