<?php

namespace Deadzombies\Http\Controllers\Admin;


use Deadzombies\Http\Controllers\Controller;
use Deadzombies\Model\Category;
use Deadzombies\Model\Game;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\URL;
use Illuminate\View\View;

class IndexController extends Controller
{
    public function getIndex(Game $game)
    {
        $games = $game->all();
        $games->each(function ($games) {
            $games->url = route('admin.getGame', $games->game_url);
        });

        //dd($games);
        return view('admin',['games'=>$games]);
    }
}