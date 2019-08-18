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
        $popularGames = $imageModel->makeGameImgUrl(
            $game
                ->with(['image'
                => function ($query) {
                        $query->where('main_img', true)->first();
                    }])
                ->where('game_show', true)
                ->orderBy('game_played')
                ->limit(21)
                ->get(),
            true
        );
        foreach ($popularGames as $item) {
            $item->url = route('getGame', $item->game_url, false);
        }

        $newGames = $imageModel->makeGameImgUrl($game
            ->with(['image'
            => function ($query) {
                    $query->where('main_img', true)->first();
                }])
            ->where('game_show', true)
            ->orderBy('id', 'desc')
            ->limit(9)
            ->get(),
            true
        );
        foreach ($newGames as $item) {
            $item->url = route('getGame', $item->game_url, false);
        }

        $bestGames = $imageModel->makeGameImgUrl(
            $game
                ->with(['image'
                => function ($query) {
                        $query->where('main_img', true)->first();
                    }])->where('game_show', true)
                ->orderBy('game_like')
                ->limit(9)
                ->get(),
            true
        );
        foreach ($bestGames as $item) {
            $item->url = route('getGame', $item->game_url, false);
        }

        $categories = $imageModel->makeCategoryImgUrl(
            $categoryModel
                ->with(['image'
                => function ($query) {
                        $query->where('main_img', true)->first();
                    }])
                ->where('display', true)
                ->withCount('game')
                ->orderBy('game_count','desc')
                ->get()
        );
        foreach ($categories as $item) {
            $item->url = route('getCategory', $item->cat_url, false);
        }
        $indexPage = $pageModel->where('name', 'index')->get()->first();

        //microdata
        $indexPage->microdataDesc = substr(strip_tags($indexPage->description), 0, 300);
        $breadCrumb = [];

        if ($categories->isNotEmpty()) {
            $i = 1;
            foreach ($categories as $category) {
                if ($i == 6) {
                    break;
                }
                $breadCrumb[] = [
                    "@type" => "ListItem",
                    "position" => $i,
                    "item" => ["@id" => route('getCategory', $category->cat_url, false),
                        "name" => $category->cat_name]
                ];
                $i++;
            }
        }
        $indexPage->microdataBreadcrumb = json_encode($breadCrumb);

        //        $tags = collect();
//        $tags = $imageModel->makeTagImgUrl(
//            $tagModel
//                ->with(['image'
//                => function ($query) {
//                        $query->where('main_img', true)->first();
//                    }])
//                ->where('display', true)
//                ->limit(50)
//                ->get()
//        );

        //TODO redactor

        //$indexPage->descWithP = '<p>' . str_replace(array("\r\n", "\r", "\n"), '</p><p>', $indexPage->description) . '</p>';

        return view('index', ['popularGames' => $popularGames,
            'newGames' => $newGames,
            'bestGames' => $bestGames,
            'categories' => $categories,
            'indexPage' => $indexPage,
//            'tags' => $tags,
            ]);
    }
 }
