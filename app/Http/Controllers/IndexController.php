<?php

namespace Deadzombies\Http\Controllers;


use Deadzombies\Model\Game;

class IndexController extends Controller
{
    public function getIndex(Game $game)
    {
        //var_dump($game::all());
        return view('welcome');
    }
}