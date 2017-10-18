<?php

namespace Deadzombies\Http\Controllers\Admin;

use Deadzombies\Model\Category;
use Illuminate\Http\Request;
use Deadzombies\Http\Controllers\Controller;

class CategoryController extends Controller
{
    //todo only show games
    public function getCategory(Category $Category)
    {
        $games = $Category->game;
        foreach ($games as $game) {
            $game->url = route('admin.getGame', $game->game_url);
            $game->img = file_exists(public_path() . '/img/' . $game->game_url . '.jpg') ?
                '/img/' . $game->game_url . '.jpg' :
                '/img/empty.jpg';
            //dd($game->img);
        }
        return view('category', ['games' => $games, 'category' => $Category]);
    }

    public function putCategory(Category $Category,Request $request)
    {
dd($Category,$request);
}
}
