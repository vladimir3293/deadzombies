<?php

namespace Deadzombies\Http\Controllers;

use Deadzombies\Model\Game;
use Deadzombies\Model\Image;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    public function SearchGame(Request $request, Game $gameModel, Image $imageModel)
    {
        $search = preg_replace('/[^-a-zA-Z0-9а-яА-ЯёЁ ]/', '', $request->q);
        $games = $imageModel->makeGameImgUrl(
            $gameModel
                ->with(['image'
                => function ($query) {
                        $query->where('main_img', true)->first();
                    }])
                ->where([['game_name', 'LIKE', '%' . $request->q . '%'], ['game_show', true]])
                ->paginate(60));
        foreach ($games as $game) {
            $game->url = route('getGame', $game->game_url);
        }
        $params = ['q' => $request->q];

        return view('searchResult', ['games' => $games, 'params' => $params]);
    }
}
