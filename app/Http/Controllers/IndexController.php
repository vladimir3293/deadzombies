<?php

namespace Deadzombies\Http\Controllers;


use Deadzombies\Model\Game;
use Deadzombies\Model\Page;

class IndexController extends Controller
{
    public function getIndex(Game $game, Page $page)
    {
        //TODO transfer to model
        //TODO refactor img
        //TODO googleof googleoff
        //dd($test);
        //dd($test->update(['game_show'=>1]));

        //$pageIndex = $page->where('name', 'index')->get()->first();

        $popularGames = $game->where('game_show', true)->orderBy('game_like')->simplePaginate(5);
        //dd($games);
        $popularGames->each(function ($games) {
            $games->url = route('getGame', $games->game_url, false);
            $games->img = file_exists(public_path() . '/img/' . $games->game_url . '.jpg') ?
                '/img/' . $games->game_url . '.jpg' :
                '/img/site/empty.jpg';
        });
        $newGames = $game->where('game_show', true)->simplePaginate(5);
        return view('index', ['popularGames' => $popularGames,
            'newGames' => $newGames]);
    }
}
