<?php

namespace Deadzombies\Http\Controllers\Admin;

use Deadzombies\Model\Game;
use Illuminate\Http\Request;
use Deadzombies\Http\Controllers\Controller;

class GameController extends Controller
{
    public function getGame(Game $Game)
    {
        //$Game->url = route('admin.getGame', $game->game_url);
        //dd($Game->Category);

        return view('game', ['game' => $Game]);

    }

    public function putGame(Game $Game)
    {
        dd($Game);
    }
}
