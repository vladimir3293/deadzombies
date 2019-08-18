<?php

namespace Deadzombies\Http\Controllers;


use Deadzombies\Model\Category;
use Deadzombies\Model\Game;
use Deadzombies\Model\Image;
use Illuminate\Http\Request;

class GameController
{
    //TODO create helper to add <p>
    public function getGame(Game $game, Request $request, Image $imageModel)
    {
        abort_unless($game->game_show, 404, 'not displayed');
        $game->increment('game_played');
        if ($game->category->where('display', true)->get()->isNotEmpty()) {
            $game->categoryUrl = route('getCategory', $game->category->cat_url, false);
        }
        //        if (!empty($game->category->display)) {
//            $game->categoryUrl = route('getCategory', $game->category->cat_url, false);
//            $game->cat_name = $game->category->cat_name;
//        }

        //coefficient of relationship heght to width;
//        $game->maxHeight = intval(100 * ($game->height / $game->width));
        //for max width from display height in vh
//        $game->maxWidth = intval(85 * ($game->width / $game->height));

        $game->tagsDisplayed = $imageModel->makeTagImgUrl(
            $game->tags()
                ->with(['image'
                => function ($query) {
                        $query->where('main_img', true)->first();
                    }])
                ->where('display', true)
                ->get()
        );
        foreach ($game->tagsDisplayed as $item) {
            $item->fullUrl = route('getTag', $item->url, false);;
        }

//        $game->descWithP = '<p>' . str_replace(array("\r\n", "\r", "\n"), '</p><p>', $game->game_desc) . '</p>';
        $game->gameControlWithP = '<p>' . str_replace(array("\r\n", "\r", "\n"), '</p><p>', $game->game_control) . '</p>';
        $mainImg = $game->image()->where('main_img', true)->first();
        if ($mainImg) {
            $game->image = collect([$mainImg]);
        } else {
            $game->image = collect();
        }
        $game->url = route('getGame', $game->game_url, false);
        $game = $imageModel->makeGameImgUrl(collect([$game]), true)->first();

        //TODO select logic
        //random games
        $countRows = $game->where('game_show', true)->count();

        $similarGames = $imageModel->makeGameImgUrl(
            $game->where('game_show', true)
                ->with(['image'
                => function ($query) {
                        $query->where('main_img', true)->first();
                    }])
                ->offset(mt_rand(0, $countRows - 15))
                ->limit(15)
                ->get()
        );
        foreach ($similarGames as $item) {
            $item->url = route('getGame', $item->game_url, false);;
        }
        //random Games for block New Games
        $newGames = $imageModel->makeGameImgUrl(
            $game->where('game_show', true)
                ->with(['image'
                => function ($query) {
                        $query->where('main_img', true)->first();
                    }])
                ->offset(mt_rand(0, $countRows - 12))
                ->limit(12)
                ->get()
        );
        foreach ($newGames as $item) {
            $item->url = route('getGame', $item->game_url, false);;
        }
        //TODO database
        //TODO refactoring
        $game->rating = mt_rand(30, 50) / 10;

        $breadCrumb = [];
        if ($game->categoryUrl) {
            $breadCrumb[] = [
                "@type" => "ListItem",
                "position" => 1,
                "item" => ["@id" => route('getCategory', $game->category->cat_url, false),
                    "name" => $game->category->cat_name]
            ];
        }
        if ($game->tagsDisplayed->isNotEmpty()) {
            $i = 2;
            foreach ($game->tagsDisplayed as $tag) {
                if ($i == 6) {
                    break;
                }
                $breadCrumb[] = [
                    "@type" => "ListItem",
                    "position" => $i,
                    "item" => ["@id" => route('getTag', $tag->url, false),
                        "name" => $tag->name]
                ];
                $i++;
            }
        }
        $game->microdataBreadcrumb = json_encode($breadCrumb);
        $game->microdataDesc = substr(strip_tags($game->game_desc), 0, 300);


//        dd($game->rating);
        //dd($similarGames->first());
        //echo $game->descWithP;
        //$Game->categoryUrl = route('getCat', $Category->cat_url);
        return view('game', [
            'game' => $game,
            'similarGames' => $similarGames,
            'newGames' => $newGames,
        ]);
    }
}