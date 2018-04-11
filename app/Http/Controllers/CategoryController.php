<?php


namespace Deadzombies\Http\Controllers;


use Deadzombies\Model\Category;

class CategoryController extends Controller
{
    public function getCategory(Category $Category)
    {
        //TODO pagination
        $games = $Category->game()->where('game_show', true)->get();
        //dd($games);

        foreach ($games as $game){
            $game->url = route('getGame', ['Category' => $Category->cat_url, 'Game' => $game->game_url]);
            $game->img = file_exists(public_path() . '/img/' . $game->game_url . '.jpg') ?
                '/img/' . $game->game_url . '.jpg' :
                '/img/site/empty.jpg';
        }
       // dd($games);
        return view('category', ['games' => $games, 'category' => $Category]);
    }
}