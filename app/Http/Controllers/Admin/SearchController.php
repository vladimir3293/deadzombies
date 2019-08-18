<?php

namespace Deadzombies\Http\Controllers\Admin;

use Deadzombies\Model\Game;
use Deadzombies\Model\Image;
use Illuminate\Http\Request;
use Deadzombies\Http\Controllers\Controller;

class SearchController extends Controller
{
    public function SearchGame(Request $request, Game $gameModel, Image $imageModel)
    {
        $games = $imageModel->makeGameImgUrl(
            $gameModel
                ->with(['image'
                => function ($query) {
                        $query->where('main_img', true)->first();
                    }])
                ->where([['game_name', 'LIKE', '%' . $request->game_name . '%'], ['game_show', true]])
                ->paginate(60));
        foreach ($games as $game) {
            $game->url = route('admin.getGame', $game->id);
        }
        return view('admin.searchResult', ['games' => $games]);
    }
    //
}
