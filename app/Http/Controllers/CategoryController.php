<?php


namespace Deadzombies\Http\Controllers;


use Deadzombies\Model\Category;

class CategoryController extends Controller
{
    public function getCategory(Category $category)
    {
        //TODO pagination
        //dd($category->display);

        abort_unless($category->display, 404);

        $games = $category->game()->where('game_show', true)->simplePaginate(12);
        foreach ($games as $game) {
            $game->url = route('getGame', ['Game' => $game->game_url], false);
            $game->img = file_exists(public_path() . '/img/' . $game->game_url . '.jpg') ?
                '/img/' . $game->game_url . '.jpg' :
                '/img/site/empty.jpg';
        }
        $category->tagsDisplayed = $category->tags()->where('display', true)->get();
        //dd($category);
        $category->descWithP = '<p>'.str_replace(array("\r\n", "\r", "\n"), '</p><p>', $category->cat_desc).'</p>';

        //dd($category);
        return view('category', ['games' => $games, 'category' => $category]);
    }
}