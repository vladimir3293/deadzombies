<?php

namespace Deadzombies\Http\Controllers;


use Deadzombies\Model\Game;

class IndexController extends Controller
{
    public function getIndex(Game $game)
    {
        //TODO transfer to model
        //TODO pagination
        $games = $game->where('game_show', true)->get();
        $games->each(function ($games) {
            $cat_url = $games->category()->get()[0]->cat_url;
            $games->url = route('getGame', ['category' => $cat_url, 'game' => $games->game_url]);
            $games->img = file_exists(public_path() . '/img/' . $games->game_url . '.jpg') ?
                '/img/' . $games->game_url . '.jpg' :
                '/img/empty.jpg';
        });

        //dd($games);
        return view('indexPage', ['games' => $games]);
    }
}