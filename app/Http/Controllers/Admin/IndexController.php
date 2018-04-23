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
        //TODO problem with height
        //TODO tags unique
        //TODO tag tag ubique
        //TODO when delete category
        //TODO tags
        //TODO create name
        //TODO publish and unpublish to GET
        //TODO search in select form
        //TODO N + 1 query problem

        $pageIndex = $page->where('name', 'index')->get()->first();


        $games = $game->paginate(24);
        //dd($games);
        $games->each(function ($games) {
            $games->url = route('admin.getGame', $games->game_url);
            $games->img = file_exists(public_path() . '/img/' . $games->game_url . '.jpg') ?
                '/img/' . $games->game_url . '.jpg' :
                '/img/site/empty.jpg';
        });
        return view('admin.index', ['games' => $games, 'page' => $pageIndex]);
    }
}