<?php

namespace Deadzombies\Http\Controllers\Admin;


use Deadzombies\Http\Controllers\Controller;
use Deadzombies\Model\Category;
use Deadzombies\Model\Game;
use Deadzombies\Model\Page;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\URL;
use Illuminate\View\View;

class IndexController extends Controller
{
    public function getIndex(Game $game, Page $page)
    {
        //TODO transfer to model
        //TODO pagination
        $pageIndex = $page->where('id',1)->get()->first();


        $games = $game->simplePaginate(12);
        //dd($games);
        $games->each(function ($games) {
            $games->url = route('admin.getGame', $games->game_url);
            $games->img = file_exists(public_path() . '/img/' . $games->game_url . '.jpg') ?
                '/img/' . $games->game_url . '.jpg' :
                '/img/empty.jpg';
        });
        return view('admin.index',['games'=>$games, 'page'=>$pageIndex]);
    }
}