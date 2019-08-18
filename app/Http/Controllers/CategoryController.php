<?php


namespace Deadzombies\Http\Controllers;


use Deadzombies\Model\Category;
use Deadzombies\Model\Image;

class CategoryController extends Controller
{
    public function getCategory(Category $category, Image $imageModel)
    {
        //TODO pagination
        abort_unless($category->display, 404);
        $category->url = route('getCategory', $category->cat_url, false);
        $category->gamesDisplayed = $imageModel->makeGameImgUrl(
            $category->game()
                ->with(['image'
                => function ($query) {
                        $query->where('main_img', true)->first();
                    }])
                ->where('game_show', true)
                ->paginate(60)
        );
        foreach ($category->gamesDisplayed as $item) {
            $item->url = route('getGame', $item->game_url, false);
        }

        $category->tagsDisplayed = $imageModel->makeTagImgUrl(
            $category->tags()
                ->with(['image'
                => function ($query) {
                        $query->where('main_img', true)->first();
                    }])
                ->where('display', true)
                ->get()
        );
        foreach ($category->tagsDisplayed as $item) {
            $item->fullUrl = route('getTag', $item->url, false);
        }

        $category->newGames = $imageModel->makeGameImgUrl(
            $category->game()
                ->with(['image'
                => function ($query) {
                        $query->where('main_img', true)->first();
                    }])
                ->where('game_show', true)
                ->orderBy('id')
                ->limit(10)
                ->get()
        );
        foreach ($category->newGames as $item) {
            $item->url = route('getGame', $item->game_url, false);
        }

        $category->bestGames = $imageModel->makeGameImgUrl(
            $category->game()
                ->with(['image'
                => function ($query) {
                        $query->where('main_img', true)->first();
                    }])
                ->where('game_show', true)
                ->orderBy('game_like')
                ->limit(10)
                ->get()
        );
        foreach ($category->bestGames as $item) {
            $item->url = route('getGame', $item->game_url, false);
        }

        $mainImg = $category->image()->where('main_img', true)->first();
        if ($mainImg) {
            $category->image = collect([$mainImg]);
        } else {
            $category->image = collect();
        }

        $category = $imageModel->makeGameImgUrl(collect([$category]), true)->first();
        $breadCrumb[] = [
            "@type" => "ListItem",
            "position" => 1,
            "item" => ["@id" => "/",
                "name" => "На главную"]
        ];
        if ($category->bestGames->isNotEmpty()) {
            $i = 2;
            foreach ($category->bestGames as $game) {
                if ($i == 6) {
                    break;
                }
                $breadCrumb[] = [
                    "@type" => "ListItem",
                    "position" => $i,
                    "item" => ["@id" => route('getCategory', $game->game_url, false),
                        "name" => $game->game_name]
                ];
                $i++;
            }
        }
        $category->microdataBreadcrumb = json_encode($breadCrumb);
        $category->microdataDesc = substr(strip_tags($category->cat_desc), 0, 300);
//        dd($category);

        return view('category', ['category' => $category]);
    }
}