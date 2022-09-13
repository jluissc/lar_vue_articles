<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Http\Requests\ArticleRequest;
use Illuminate\Http\Request;

class ArticleController extends Controller
{ 
    public function index(Request $request)
    {
        return Article::paginate($request->per_page);
    }
 
    public function store(ArticleRequest $request)/* crear new article */
    {
        $article = new Article();
        $article->create($request->all());
    }
 
    public function show(Article $article)
    {
        return $article;
    }
 
    public function update(ArticleRequest $request, Article $article)
    {
        $article->update($request->all());
    }
 
    public function destroy(Article $article)
    {
        $article->delete();
    }
}
