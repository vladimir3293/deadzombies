<?php


namespace Deadzombies\Http\Controllers;


use Deadzombies\Model\Category;

class CategoryController extends Controller
{
    public function getCategory(Category $category)
    {
        //TODO pagination
        abort_unless($category->display, 404);

        $category->gamesDisplayed = $category->game()->where('game_show', true)->simplePaginate(10);
        foreach ($category->gamesDisplayed as $game) {
            $game->url = route('getGame', ['Game' => $game->game_url], false);
            $game->img = file_exists(public_path() . '/img/' . $game->game_url . '.jpg') ?
                '/img/' . $game->game_url . '.jpg' :
                '/img/site/empty.jpg';
        }
        $category->tagsDisplayed = $category->tags()->where('display', true)->get();
        $category->tagsDisplayed->each(function ($tag) {
            $tag->fullUrl = route('getTag', ['tag' => $tag->url], false);
            $mainImg = $tag->image()->where('main_img', true)->get()->first();
            if (!empty($mainImg)) {
                $tag->img = "/img/$mainImg->name.jpg";
            } else {
                $tag->img = '/img/site/empty.jpg';
            }
        });
        $category->newGames = $category->game()->where('game_show', true)->orderBy('id')->limit(10)->get();
        $category->newGames->each(function ($games) {
            $games->url = route('getGame', $games->game_url, false);
            $games->img = file_exists(public_path() . '/img/' . $games->game_url . '.jpg') ?
                '/img/' . $games->game_url . '.jpg' :
                '/img/site/empty.jpg';
        });

        return view('category', ['category' => $category]);
    }
}