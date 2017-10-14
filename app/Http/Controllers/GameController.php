<?php

namespace Deadzombies\Http\Controllers;


use Deadzombies\Model\Game;

class GameController
{
    public function getAllGames(Game $game)
    {
        //var_dump($game);
        var_dump($game::all());
        //echo __METHOD__;
    }

    public function test()
    {

        $users = new \Deadzombies\Game();
        $users->game_url = '123';
        $users->save();
        //var_dump($users = \Deadzombies\Game::all());

    }
}