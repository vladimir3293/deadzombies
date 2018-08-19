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

        $games = $game->where('game_show', true)->simplePaginate(5);
        //dd($games);
        $games->each(function ($games) {
            $games->url = route('getGame', $games->game_url, false);
            $games->img = file_exists(public_path() . '/img/' . $games->game_url . '.jpg') ?
                '/img/' . $games->game_url . '.jpg' :
                '/img/site/empty.jpg';
        });
        return view('index', ['games' => $games]);
    }
}
