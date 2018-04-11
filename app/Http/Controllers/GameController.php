<?php

namespace Deadzombies\Http\Controllers;


use Deadzombies\Model\Category;
use Deadzombies\Model\Game;
use Illuminate\Http\Request;

class GameController
{
    public function getGame(Game $game, Request $request)
    {

        //die('fs');
        /*   "game_name" => "Romantic Royal Couple"
       "game_url" => "romantic-royal-couple"
       "game_desc" => "  Beautiful princess and the prince have a romantic date, they all need to elaborate dress up, come together to help them choose beautiful clothes and hairstyle ▶"
       "game_title" => "Romantic Royal Couple"
       "game_desc_meta" => "Romantic Royal Couple"
       "game_key_meta" => "Romantic Royal Couple"
       "game_control" => "mouse keyboard"
       "game_like" => 0
       "game_played" => 0
       "game_show" => 1
       "category_id" => 61
       "width" => 700
       "height" => 500
       "source" => "https://html5.GameDistribution.com/8bc4ad8afc05474883e7d9937467167c/"
       "img" => "//img.gamedistribution.com/8bc4ad8afc05474883e7d9937467167c.jpg"
       "original_url" => "https://gamedistribution.com/games/dress-up/romantic-royal-couple.html"
   */
        //dd($game);
        //dd($game->category);
        if(isset($game->category->cat_url)) {
            $game->cat_url = $game->category->cat_url;
            $game->cat_name = $game->category->cat_name;
        }
        $game->gameHeight = 868 * $game->height / $game->width;
        // dd($game);
        //$Game->categoryUrl = route('getCat', $Category->cat_url);
        return view('game', ['game' => $game]);
    }
}