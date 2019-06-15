<?php

namespace Deadzombies\Http\Controllers;


use Deadzombies\Model\Category;
use Deadzombies\Model\Game;
use Deadzombies\Model\Image;
use Deadzombies\Model\Page;
use Deadzombies\Model\Tag;
use Illuminate\Database\Eloquent\Collection;

class IndexController extends Controller
{
    public function getIndex(Game $game, Category $categoryModel, Page $pageModel, Tag $tagModel, Image $imageModel)
    {
        //TODO transfer to model
        //TODO refactor img
        //TODO googleof googleoff
        $popularGames = $imageModel->makeGameImgUrl($game->where('game_show', true)
            ->orderBy('game_played')
            ->limit(21)
            ->get(),
            true
        );

        $newGames = $imageModel->makeGameImgUrl($game->where('game_show', true)
            ->orderBy('id', 'desc')
            ->limit(9)
            ->get(),
            true
        );

        $bestGames = $imageModel->makeGameImgUrl(
            $game->where('game_show', true)
                ->orderBy('game_like')
                ->limit(9)
                ->get(),
            true
        );

        $categories = $imageModel->makeCategoryImgUrl(
            $categoryModel
                ->where('display', true)
                ->get()
        );

        $tags = $imageModel->makeTagImgUrl(
            $tagModel
                ->where('display', true)
                ->get()
        );

        $indexPage = $pageModel->where('name', 'index')->get()->first();
        //TODO redactor

        //$indexPage->descWithP = '<p>' . str_replace(array("\r\n", "\r", "\n"), '</p><p>', $indexPage->description) . '</p>';

        return view('index', ['popularGames' => $popularGames,
            'newGames' => $newGames,
            'bestGames' => $bestGames,
            'categories' => $categories,
            'indexPage' => $indexPage,
            'tags' => $tags,]);
    }

    public function makeImgUrl($gamesCollection)
    {
        $gamesCollection->each(function ($games) {
            $games->url = route('getGame', $games->game_url, false);
            $mainImg = $games->image()->where('main_img', true)->get()->first();
            if (!empty($mainImg)) {
                $games->img = "/img/$mainImg->name.jpg";
                $games->imgAlt = $mainImg->alt;
                $games->imgTitle = $mainImg->title;
            } elseif (file_exists(public_path() . '/img/' . $games->game_url . '.jpg')) {
                $games->img = '/img/' . $games->game_url . '.jpg';
                $games->imgAlt = $games->game_name;
                $games->imgTitle = $games->game_title;
            } else {
                $games->img = '/img/site/empty.jpg';
                $games->imgAlt = 'пустое изображение';
                $games->imgTitle = 'пустое изображение';
            }
        });
        if ($gamesCollection[0]->img != '/img/site/empty.jpg') {
            $imgUrl = explode('.', $gamesCollection[0]->img);
            $gamesCollection[0]->img = $imgUrl[0] . '-large.jpg';
        }
        return $gamesCollection;
    }
}
