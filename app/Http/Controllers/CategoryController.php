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
                ->where('game_show', true)
                ->simplePaginate(10)
        );

        $category->tagsDisplayed = $imageModel->makeTagImgUrl(
            $category->tags()
                ->where('display', true)
                ->get()
        );

        $category->newGames = $imageModel->makeGameImgUrl(
            $category->game()
                ->where('game_show', true)
                ->orderBy('id')->limit(10)
                ->get()
        );

        return view('category', ['category' => $category]);
    }
}