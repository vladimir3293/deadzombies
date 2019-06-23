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

        $category->gamesDisplayed = $imageModel->makeGameImgUrl(
            $category->game()
                ->with(['image'
                => function ($query) {
                        $query->where('main_img', true)->first();
                    }])
                ->where('game_show', true)
                ->simplePaginate(100)
        );

        $category->tagsDisplayed = $imageModel->makeTagImgUrl(
            $category->tags()
                ->with(['image'
                => function ($query) {
                        $query->where('main_img', true)->first();
                    }])
                ->where('display', true)
                ->get()
        );

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

        return view('category', ['category' => $category]);
    }
}