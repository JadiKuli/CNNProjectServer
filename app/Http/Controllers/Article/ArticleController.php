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
}
