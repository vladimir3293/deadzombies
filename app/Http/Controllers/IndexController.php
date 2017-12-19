<?php

namespace Deadzombies\Http\Controllers;


use Deadzombies\Model\Game;
use Deadzombies\Parser\Parser;

class IndexController extends Controller
{
    public function getIndex(Game $game, Parser $parser)
    {
        //TODO transfer to model
        //TODO pagination
        //dd($parser->getGamesUrls(2));
        $games = $game->where('game_show', true)->get();
        $games->each(function ($games) {
            $cat_url = $games->category()->get()[0]->cat_url;
            $games->url = route('getGame', ['category' => $cat_url, 'game' => $games->game_url]);
            $games->img = file_exists(public_path() . '/img/' . $games->game_url . '.jpg') ?
                '/img/' . $games->game_url . '.jpg' :
                '/img/empty.jpg';
        });
//        $test = $this->getGamesUrls();

        //dd($test);
        return view('indexPage', ['games' => $games]);
    }
}
