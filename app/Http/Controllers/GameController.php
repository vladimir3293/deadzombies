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
        abort_unless($game->game_show, 404, 'not displayed');
        $game->categoryUrl = route('getCategory', $game->category->cat_url, false);
//        if (!empty($game->category->display)) {
//            $game->categoryUrl = route('getCategory', $game->category->cat_url, false);
//            $game->cat_name = $game->category->cat_name;
//        }

        //coefficient of relationship heght to width;
        $game->maxHeight = intval(100 * ($game->height / $game->width));
        //for max width from display height in vh
        $game->maxWidth = intval(85 * ($game->width / $game->height));

        $game->tagsDisplayed = $game->tags()->where('display', true)->get();
        $game->descWithP = '<p>' . str_replace(array("\r\n", "\r", "\n"), '</p><p>', $game->game_desc) . '</p>';
        $game->gameControlWithP = '<p>' . str_replace(array("\r\n", "\r", "\n"), '</p><p>', $game->game_control) . '</p>';
        //TODO select logic
        $gamesSimilar = $game->where('game_show', true)->limit(15)->get();
        $gamesSimilar->each(function ($game) {
            $game->url = route('getGame', $game->game_url, false);
            $game->img = file_exists(public_path() . '/img/' . $game->game_url . '.jpg') ?
                '/img/' . $game->game_url . '.jpg' :
                '/img/site/empty.jpg';
        });
        $newGames = $game->where('game_show', true)->limit(12)->orderBy('id', 'desc')->get();
        $newGames->each(function ($game) {
            $game->url = route('getGame', $game->game_url, false);
            $game->img = file_exists(public_path() . '/img/' . $game->game_url . '.jpg') ?
                '/img/' . $game->game_url . '.jpg' :
                '/img/site/empty.jpg';
        });
        //dd($gamesSimilar->first());
        //echo $game->descWithP;
        //$Game->categoryUrl = route('getCat', $Category->cat_url);
        return view('game', [
            'game' => $game,
            'gamesSimilar' => $gamesSimilar,
        ]);
    }
}