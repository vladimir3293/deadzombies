<?php

namespace Deadzombies\Http\Controllers;


use Deadzombies\Model\Category;
use Deadzombies\Model\Game;
use Illuminate\Http\Request;

class GameController
{
    public function getGame(Category $Category, Game $Game, Request $request)
    {
        dd($Category, $Game);
        $Game->categoryUrl = route('getCat', $Category->cat_url);
        return view('game','game'= $Game);
    }
}