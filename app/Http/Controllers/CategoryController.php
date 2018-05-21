<?php


namespace Deadzombies\Http\Controllers;


use Deadzombies\Model\Category;

class CategoryController extends Controller
{
    public function getCategory(Category $category)
    {
        //TODO pagination
        $games = $category->game()->where('game_show', true)->get();
        foreach ($games as $game){
            $game->url = route('getGame', ['Game' => $game->game_url],false);
            $game->img = file_exists(public_path() . '/img/' . $game->game_url . '.jpg') ?
                '/img/' . $game->game_url . '.jpg' :
                '/img/site/empty.jpg';
        }
        $category->tagsDisplayed = $category->tags()->where('display', true)->get();
        //dd($category);
        return view('category', ['games' => $games, 'category' => $category]);
    }
}