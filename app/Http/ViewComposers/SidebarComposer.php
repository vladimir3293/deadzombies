<?php

namespace Deadzombies\Http\ViewComposers;


use Deadzombies\Model\Category;
use Deadzombies\Model\Game;
use Illuminate\Http\Request;
use Illuminate\View\View;
/*
 * del
 */
class SidebarComposer
{
    public $category;

    public $request;
    public $game;

    public function __construct(Category $category, Request $request, Game $game)
    {
        //dd($request->fullUrl(),$request->ip(),$request->segments());
        $this->category = $category;
        $this->request = $request;
        $this->game = $game;

    }

    /**
     * top and new games block
     * @param View $view
     */
    public function compose(View $view)
    {
        $topGames = [];
        $newGames = [];

        if (preg_match('/^(.+)\/(.+)$/', $this->request->path())) {

            $catUrl = $this->request->path();
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

        if (preg_match('/^[^\/].+$/', $this->request->path())) {
            $catUrl = $this->request->path();
            //dd($catUrl);
            $category = $this->category->where('cat_url', $catUrl)->get()->first();
            //dd($this->category->where('cat_url', $catUrl)->get());
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

        if (preg_match('/^\/$/', $this->request->path())) {

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