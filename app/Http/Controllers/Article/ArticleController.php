<?php

namespace App\Http\Controllers\Article;

use App\Http\Controllers\BaseContoller;
use App\Models\Article;
use Illuminate\Http\Request;

class ArticleController extends BaseContoller
{
    // Fetch All Articles
    public function fetchAllArticles()
    {
        return $this->successResponse(
            Article::select('id', 'title', 'created_at')->get(),
            "Fetched all articles successfully",
            200
        );
    }

    // Fetch Article By ID
    public function fetchArticleById($id)
    {
        $article = Article::find($id);

        return $this->successResponse(
            $article,
            "Fetched article successfully",
            200
        );
    }

    // Admin Privilege Required
    // Create Article
    public function createArticle(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
        ]);

        $article = Article::create([
            'title' => $request->title,
            'content' => $request->content,
        ]);

        return $this->successResponse(
            $article,
            "Article created successfully",
            201
        );
    }

    // Delete Article
    public function deleteArticle($id)
    {
        $article = Article::find($id);

        if (!$article) {
            return $this->errorResponse("Article not found", 404);
        }

        $article->delete();

        return $this->successResponse(
            null,
            "Article deleted successfully",
            200
        );
    }
    // End of Admin Privilege Required
}
