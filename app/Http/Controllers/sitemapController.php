<?php

namespace Deadzombies\Http\Controllers;

use Deadzombies\Model\Category;
use Deadzombies\Model\Game;
use Illuminate\Http\Request;

class sitemapController extends Controller

{
    public function getSitemap(Request $request, Game $gameModel, Category $categoryModel)
    {
        $category = $categoryModel->where('display', true)->get();
        $games = $gameModel->where('game_show', true)->get();
        return response()
            ->view('sitemap', ['games' => $games, 'category' => $category])
            ->header('Content-Type', 'text/xml');
    }
}
