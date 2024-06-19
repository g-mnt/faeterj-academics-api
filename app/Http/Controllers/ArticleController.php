<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Resources\ArticleResource;
use App\Models\Article;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

class ArticleController extends Controller
{
    public function index(): ResourceCollection
    {
        return ArticleResource::collection(Article::query()
            ->with('author')
            ->paginate());
    }
}
