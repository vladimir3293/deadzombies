<?php

namespace Deadzombies\Http\Controllers;


use Deadzombies\Model\Category;
use Deadzombies\Model\Game;
use Deadzombies\Model\Page;
use Deadzombies\Model\Tag;
use Illuminate\Database\Eloquent\Collection;

class IndexController extends Controller
{
    public function getIndex(Game $game, Category $categoryModel, Page $pageModel, Tag $tagModel)
    {
        //TODO transfer to model
        //TODO refactor img
        //TODO googleof googleoff
        $popularGames = $game->where('game_show', true)->orderBy('game_played')->limit(21)->get();
        $popularGames->each(function ($games) {
            $games->url = route('getGame', $games->game_url, false);
            $games->img = file_exists(public_path() . '/img/' . $games->game_url . '.jpg') ?
                '/img/' . $games->game_url . '.jpg' :
                '/img/site/empty.jpg';
        });
        $popularGames->first(function ($game) {
            $game->img = file_exists(public_path() . '/img/' . $game->game_url . '.jpg') ?
                '/img/' . $game->game_url . '-large.jpg' :
                '/img/site/empty.jpg';
        });

        $newGames = $game->where('game_show', true)->orderBy('id', 'desc')->limit(9)->get();
        $newGames->each(function ($games) {
            $games->url = route('getGame', $games->game_url, false);
            $games->img = file_exists(public_path() . '/img/' . $games->game_url . '.jpg') ?
                '/img/' . $games->game_url . '.jpg' :
                '/img/site/empty.jpg';
        });
        $newGames->first(function ($game) {
            $game->img = file_exists(public_path() . '/img/' . $game->game_url . '.jpg') ?
                '/img/' . $game->game_url . '-large.jpg' :
                '/img/site/empty.jpg';
        });

        $bestGames = $game->where('game_show', true)->orderBy('game_like')->limit(9)->get();
        $bestGames->each(function ($games) {
            $games->url = route('getGame', $games->game_url, false);
            $games->img = file_exists(public_path() . '/img/' . $games->game_url . '.jpg') ?
                '/img/' . $games->game_url . '.jpg' :
                '/img/site/empty.jpg';
        });
        $bestGames->first(function ($game) {
            $game->img = file_exists(public_path() . '/img/' . $game->game_url . '.jpg') ?
                '/img/' . $game->game_url . '-large.jpg' :
                '/img/site/empty.jpg';
        });
        $categories = $categoryModel->where('display', true)->get();
        $categories->each(function ($category) {
            $category->url = route('getCategory', ['cat' => $category->cat_url], false);
            $mainImg = $category->image()->where('main_img', true)->get()->first();
            if (!empty($mainImg)) {
                $category->img = "/img/$mainImg->name.jpg";
            } else {
                $category->img = '/img/site/empty.jpg';
            }
        });
        $tags = $tagModel->where('display', true)->get();
        $tags->each(function ($tag) {
            $tag->fullUrl = route('getTag', ['tag' => $tag->url], false);
            $mainImg = $tag->image()->where('main_img', true)->get()->first();
            if (!empty($mainImg)) {
                $tag->img = "/img/$mainImg->name.jpg";
            } else {
                $tag->img = '/img/site/empty.jpg';
            }
        });
        $indexPage = $pageModel->where('name', 'index')->get()->first();
        //TODO redactor

        //$indexPage->descWithP = '<p>' . str_replace(array("\r\n", "\r", "\n"), '</p><p>', $indexPage->description) . '</p>';

        return view('index', [
            'popularGames' => $popularGames,
            'newGames' => $newGames,
            'bestGames' => $bestGames,
            'categories' => $categories,
            'indexPage' => $indexPage,
            'tags' => $tags,
        ]);
    }
}
