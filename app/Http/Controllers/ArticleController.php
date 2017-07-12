<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\ArticleContent;
use Illuminate\Http\Request;

class ArticleController extends Controller
{
    public function list(Request $request) {
        $page = $request->input('page');

        $articles = Article::where('published_at', '<>', null)->offset($page * 12 - 12)->limit(12)->get();

        return response()->json($articles);
    }

    public function get(Request $request, $id)
    {
        $article = Article::where('published_at', '<>', null)->findOrFail($id)->toArray();

        if ($request->input('content')) {
            $article['content'] = ArticleContent::findOrFail($id)['content'];
        }

        return response()->json($article);
    }
}
