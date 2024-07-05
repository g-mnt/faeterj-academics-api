<?php

namespace App\Http\Resources;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ArticleResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        /** @var User */
        $user = auth()->user();
        return [
            'id' => $this->id,
            'title' => $this->title,
            'description' => $this->description,
            'document_url' => $this->document_url,
            'author' => AuthorResource::make($this->author),
            'favorite' => $user->favoriteArticles()->wherePivot('article_id', $this->id)->exists(),
            'status' => $this->status
        ];
    }
}
