<?php

namespace Deadzombies\Http\Controllers;


use Deadzombies\Model\Category;
use Deadzombies\Model\Game;
use Illuminate\Http\Request;

class GameController
{
    //TODO create helper to add <p>
    public function getGame(Game $game, Request $request)
    {
        if (!empty($game->category->display)) {
            $game->categoryUrl = route('getCategory', $game->category->cat_url, false);
            $game->cat_name = $game->category->cat_name;
        }
        $game->gameHeight = 868 * $game->height / $game->width;
        $game->tagsDisplayed = $game->tags()->where('display', true)->get();
        $game->descWithP = '<p>'.str_replace(array("\r\n", "\r", "\n"), '</p><p>', $game->game_desc).'</p>';
        $game->gameControlWithP = '<p>'.str_replace(array("\r\n", "\r", "\n"), '</p><p>', $game->game_control).'</p>';
        //dd($game->descWithP);
        //echo $game->descWithP;
        //$Game->categoryUrl = route('getCat', $Category->cat_url);
        return view('game', ['game' => $game]);
    }
}