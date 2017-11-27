<?php

namespace Deadzombies\Http\Controllers;


use Deadzombies\Model\Game;

class IndexController extends Controller
{
    public function getIndex(Game $game)
    {
        //TODO transfer to model
        //TODO pagination
        $games = $game->all();
        $games->each(function ($games) {
            $games->url = route('admin.getGame', $games->game_url);
        });

        //dd($games);
        return view('indexPage',['games'=>$games]);
    }
}