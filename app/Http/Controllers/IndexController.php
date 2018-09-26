<?php

namespace Deadzombies\Http\Controllers;


use Deadzombies\Model\Category;
use Deadzombies\Model\Game;
use Deadzombies\Model\Page;
use Illuminate\Database\Eloquent\Collection;

class IndexController extends Controller
{
    public function getIndex(Game $game, Page $page, Category $category)
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
        $topCategories = $category->limit(5)->get();


        return view('index', [
            'popularGames' => $popularGames,
            'newGames' => $newGames,
            'bestGames' => $bestGames,
            'topCategories' => $topCategories,
        ]);
    }
}
