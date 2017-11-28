<?php

namespace Deadzombies\Http\ViewComposers;


use Deadzombies\Model\Category;
//use Illuminate\Support\Facades\Request;
use Deadzombies\Model\Game;
use Illuminate\Http\Request;
use Illuminate\View\View;

class SidebarComposer
{
    public $category;

    public $request;
    public $game;

    public function __construct(Category $category, Request $request, Game $game)
    {
        $this->category = $category;
        $this->request = $request;
        $this->game = $game;
    }

    public function compose(View $view)
    {
//dd($this->request->path());

        if ($this->request->is('category/*')) {
            //$this->game->


            echo '1221';
        }
        if ($this->request->is('/')) {
            $topGames = $this->game->orderBy('game_like', 'desc')->take(4)->get();
            $topGames->each(function ($value) {
                $cat_url = $value->category()->get()[0]->cat_url;
                $value->url = route('getGame', ['category' => $cat_url, 'game' => $value->game_url]);
                $value->img_url = "/img/$value->game_url-small.jpg";
                //dd($value->url);
            });
            echo 'koren';
        }
        $categories = $this->category::orderBy('cat_order')->get();
        $categories->each(function ($value) {
            $value->url = route('getCat', ['cat' => $value->cat_url]);
        });
        $view->with(['menu'=>$categories,'topGames'=>$topGames]);
    }
}