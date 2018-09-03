<?php

namespace Deadzombies\Http\Controllers;


use Deadzombies\Model\Game;
use Deadzombies\Model\Page;
use Illuminate\Database\Eloquent\Collection;

class IndexController extends Controller
{
    public function getIndex(Game $game, Page $page)
    {
        //TODO transfer to model
        //TODO refactor img
        //TODO googleof googleoff
        $popularGames = $game->where('game_show', true)->orderBy('game_played')->get();
        $popularGames->each(function ($games) {
            $games->url = route('getGame', $games->game_url, false);
            $games->img = file_exists(public_path() . '/img/' . $games->game_url . '.jpg') ?
                '/img/' . $games->game_url . '.jpg' :
                '/img/site/empty.jpg';
        });
        $newGames = $game->where('game_show', true)->orderBy('id','desc')->get();
        $newGames->each(function ($games) {
            $games->url = route('getGame', $games->game_url, false);
            $games->img = file_exists(public_path() . '/img/' . $games->game_url . '.jpg') ?
                '/img/' . $games->game_url . '.jpg' :
                '/img/site/empty.jpg';
        });
        $bestGames = $game->where('game_show', true)->orderBy('game_like')->get();
        $bestGames->each(function ($games) {
            $games->url = route('getGame', $games->game_url, false);
            $games->img = file_exists(public_path() . '/img/' . $games->game_url . '.jpg') ?
                '/img/' . $games->game_url . '.jpg' :
                '/img/site/empty.jpg';
        });
        return view('index', [
            'popularGames' => $popularGames,
            'newGames' => $newGames,
            'bestGames' => $bestGames,
        ]);
    }
}
