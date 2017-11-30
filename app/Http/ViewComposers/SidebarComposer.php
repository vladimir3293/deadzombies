<?php

namespace Deadzombies\Http\ViewComposers;


use Deadzombies\Model\Category;
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
        $topGames = [];
        $newGames = [];

        if($this->request->is('*/*')){
            $catUrl = str_after($this->request->path(), '/');
            $category = $this->category->where('cat_url', $catUrl)->get()->first();
            $topGames = $category->game()->orderBy('game_like', 'desc')->take(4)->get();
            foreach ($topGames as $game) {
                $game->url = route('getGame', ['category' => $category->cat_url, 'game' => $game->game_url]);
                $game->img_url = "/img/$game->game_url-small.jpg";
            }

            $newGames = $category->game()->orderBy('game_id', 'desc')->take(4)->get();
            foreach ($newGames as $game) {
                $game->url = route('getGame', ['category' => $category->cat_url, 'game' => $game->game_url]);
                $game->imgUrl = "/img/$game->game_url-small.jpg";
            }

        }

        if ($this->request->is('category/*')) {
            $catUrl = str_after($this->request->path(), '/');
            $category = $this->category->where('cat_url', $catUrl)->get()->first();
            $topGames = $category->game()->orderBy('game_like', 'desc')->take(4)->get();
            foreach ($topGames as $game) {
                $game->url = route('getGame', ['category' => $category->cat_url, 'game' => $game->game_url]);
                $game->img_url = "/img/$game->game_url-small.jpg";
            }

            $newGames = $category->game()->orderBy('game_id', 'desc')->take(4)->get();
            foreach ($newGames as $game) {
                $game->url = route('getGame', ['category' => $category->cat_url, 'game' => $game->game_url]);
                $game->imgUrl = "/img/$game->game_url-small.jpg";
            }
        }

        if ($this->request->is('/')) {
            $topGames = $this->game->orderBy('game_like', 'desc')->take(4)->get();
            $topGames->each(function ($game) {
                $cat_url = $game->category()->get()->first()->cat_url;
                $game->url = route('getGame', ['category' => $cat_url, 'game' => $game->game_url]);
                $game->img_url = "/img/$game->game_url-small.jpg";
            });
            $newGames = $this->game->orderBy('game_id', 'desc')->take(4)->get();
            $newGames->each(function ($game) {
                $cat_url = $game->category()->get()->first()->cat_url;
                $game->url = route('getGame', ['category' => $cat_url, 'game' => $game->game_url]);
                $game->imgUrl = "/img/$game->game_url-small.jpg";
            });
        }

        $menuCategories = $this->category->orderBy('cat_order')->get();
        $menuCategories->each(function ($value) {
            $value->url = route('getCat', ['cat' => $value->cat_url]);
        });

        $view->with(['menu' => $menuCategories, 'topGames' => $topGames, 'newGames' => $newGames]);
    }
}