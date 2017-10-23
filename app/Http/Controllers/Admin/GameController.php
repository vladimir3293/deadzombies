<?php

namespace Deadzombies\Http\Controllers\Admin;

use Deadzombies\Model\Category;
use Deadzombies\Model\Game;
use Illuminate\Http\Request;
use Deadzombies\Http\Controllers\Controller;

class GameController extends Controller
{
    public function getGame(Game $Game, Category $category)
    {
        $categories = $category::all();
        //if($game->category);
        $Game->cat = $Game->category ? $Game->category->cat_name : 'НЕТ';
        //if()
        //dd($Game->category);
        //$Game->url = route('admin.getGame', $game->game_url);
        //dd($Game->Category);

        return view('game', ['game' => $Game,'categories'=>$categories]);

    }

    public function putGame(Game $Game, Request $request)
    {
        //dd($request->all());
        $Game->game_title = $request->game_title;
        $Game->game_desc_meta = $request->game_desc_meta;
        $Game->game_key_meta = $request->game_key_meta;
        $Game->game_desc = $request->game_desc;
        $Game->game_control = $request->game_control;
        $Game->game_cat = null ?? '1234';
dd($Game->game_cat);
        //$Game->game_cat = $request->game_cat;
        //dd($Game->game_show != $request->game_show);
        if ($Game->game_show != $request->game_show) {
            $Game->game_show = $request->game_show;
            dd($Game->game_show);
        }
        $Game->save();
    }
}
