<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\ArticleStoreRequest;
use App\Http\Resources\ArticleResource;
use App\Models\Article;
use App\Models\User;
use Exception;
use Illuminate\Http\File;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\ResourceCollection;
use Illuminate\Support\Facades\Storage;

class ArticleController extends Controller
{
    public function index(): ResourceCollection
    {
        return ArticleResource::collection(Article::query()
            ->with('author')
            ->paginate());
    }

    public function favorites(): ResourceCollection
    {
        /** @var User */
        $user = auth()->user();
        return ArticleResource::collection($user->favoriteArticles()->paginate());
    }

    public function self(): ResourceCollection {
        /** @var User */
        $user = auth()->user();
        return ArticleResource::collection($user->articles()->paginate());
    }

    public function toggleFavorite(Article $article): JsonResponse
    {
        /** @var User */
        $user = auth()->user();
        $alreadyFavorite = $user->favoriteArticles()->wherePivot('article_id', $article->id)->exists();
        
        if($alreadyFavorite){
            $user->favoriteArticles()->detach($article);
        }else{
            $user->favoriteArticles()->syncWithoutDetaching($article);
        }

        return response()->json([
            'message' => $alreadyFavorite ? 'Favorito removido com sucesso' : 'Artigo adicionado aos favoritos', 
            'data' => ArticleResource::make($article)
        ]);
    }

    public function store(ArticleStoreRequest $request)
    {
        /** @var User  */
        $user = auth()->user();

        /** @var File */
        try{
            $file = $request->file('pdf');
            $path = Storage::putFile(Article::ARTICLE_PATH, $file);

            $article = Article::query()->create([
                'title' => $request->validated('title'),
                'description' => $request->validated('description'),
                'document_path' => $path,
                'user_id' => $user->id,
                'approved' => $user->role == User::PROFESSOR_ROLE
            ]);

            return response()->json([
                'message' => 'Artigo criado com sucesso', 
                'data' => ArticleResource::make($article)
            ]);
        }catch(Exception $e){
            logger($e->getMessage());
            return response()
            ->json(
                ['message' => 'Algo deu errado na criação do artigo.'],
                 JsonResponse::HTTP_BAD_REQUEST
            );
        }
    }
}
