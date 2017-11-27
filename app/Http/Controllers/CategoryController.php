<?php


namespace Deadzombies\Http\Controllers;


use Deadzombies\Model\Category;

class CategoryController extends Controller
{
    public function getCategory(Category $Category)
    {
        //TODO pagination
        $games = $Category->game;
        foreach ($games as $game) {
            $game->url = route('getGame', $game->game_url);
            $game->img = file_exists(public_path() . '/img/' . $game->game_url . '.jpg') ?
                '/img/' . $game->game_url . '.jpg' :
                '/img/empty.jpg';
            //dd($game->img);
        }
        return view('category', ['games' => $games, 'category' => $Category]);
    }
}