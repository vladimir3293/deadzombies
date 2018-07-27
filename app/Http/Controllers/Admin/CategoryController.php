<?php

namespace Deadzombies\Http\Controllers\Admin;

use Deadzombies\Exceptions\CategoryUpdateException;
use Deadzombies\Model\Category;
use Deadzombies\Model\Game;
use Deadzombies\Model\Tag;
use Deadzombies\UrlGenerator\UrlGenerator;
use Illuminate\Http\Request;
use Deadzombies\Http\Controllers\Controller;

class CategoryController extends Controller
{
    public function getAll(Category $categoryModel)
    {
        $categoriesCount = $categoryModel->get()->count();
        $categories = $categoryModel->orderBy('id', 'desc')->simplePaginate(100);
        $categories->each(function ($category) {
            $category->url = route('admin.getCategory', $category->cat_url);
            $category->gamesCount = $category->game()->count();
        });

        return view('admin.category.all', ['categories' => $categories, 'categoriesCount' => $categoriesCount]);
    }

    public function getUnpublished(Category $categoryModel)
    {
        $categoriesCount = $categoryModel->where('display', 0)->get()->count();
        $categories = $categoryModel->where('display', 0)->orderBy('id', 'desc')->simplePaginate(100);
        //dd($categories);
        $categories->each(function ($category) {
            $category->url = route('admin.getCategory', $category->cat_url);
            $category->gamesCount = $category->game()->count();
        });
        return view('admin.category.unpublished', ['categories' => $categories, 'categoriesCount' => $categoriesCount]);
    }

    public function getPublished(Category $categoryModel)
    {
        $categoriesCount = $categoryModel->where('display', 1)->get()->count();
        $categories = $categoryModel->where('display', 1)->orderBy('id', 'desc')->simplePaginate(100);
        $categories->each(function ($category) {
            $category->url = route('admin.getCategory', $category->cat_url);
            $category->gamesCount = $category->game()->count();
        });
        return view('admin.category.published', ['categories' => $categories, 'categoriesCount' => $categoriesCount]);
    }

    public function postCategoryTag(Category $Category, Request $request, Tag $tagModel)
    {
        $tag = $tagModel->where('id', $request->tagId)->get()->first();
        //dd($Game, $request);
        $Category->tags()->save($tag);
        return redirect()->route('admin.getCategory', [$Category]);
    }

    public function deleteCategoryTag(Category $Category, Request $request, Tag $tagModel)
    {
        $tag = $tagModel->where('id', $request->tagId)->get();
        //dd($tag);
        $Category->tags()->detach($tag);
        return redirect()->route('admin.getCategory', [$Category]);
    }

    public function createCategory()
    {
        return view('admin.category.create');
    }

    public function postCategory(Request $request, Category $category, UrlGenerator $urlGenerator)
    {
        $category->cat_name = $request->create_category;
        $category->cat_url = $urlGenerator->createUrl($request->create_category);
        //dd($Game);
        //dd($Game->game_url);
        //dd($category);

        $category->save();
        //dd($category);
        return redirect()->route('admin.getCategory', [$category]);
    }

    //todo only show games
    public function getCategory(Category $category, Game $game, Tag $tagModel)
    {
        $tagsAll = $tagModel->orderBy('id', 'desc')->get();
        $tagsCategory = $category->tags()->orderBy('id', 'desc')->get();
        $tagsCount = $tagsCategory->count();
        $gamesCount = $category->game()->count();
        $gamesUnpublishCount = $category->game()->where('game_show', false)->count();
        $gamesPublishCount = $category->game()->where('game_show', true)->count();
        //dd($gamesCount);
        //$games = $game->where('category_id', $category->id)->paginate(12);

        $gamesPublish = $category->game()->where('game_show', true)->orderBy('id', 'desc')->paginate(20);
        $gamesUnpublish = $category->game()->where('game_show', false)->orderBy('id', 'desc')->paginate(20);
        foreach ($gamesPublish as $game) {
            $game->url = route('admin.getGame', $game->game_url, false);
            $game->img = file_exists(public_path() . '/img/' . $game->game_url . '.jpg') ?
                '/img/' . $game->game_url . '.jpg' :
                '/img/site/empty.jpg';
        }
        foreach ($gamesUnpublish as $game) {
            $game->url = route('admin.getGame', $game->game_url, false);
            $game->img = file_exists(public_path() . '/img/' . $game->game_url . '.jpg') ?
                '/img/' . $game->game_url . '.jpg' :
                '/img/site/empty.jpg';
        }
        return view('admin.category.category', [
            'gamesPublish' => $gamesPublish,
            'gamesUnpublish' => $gamesUnpublish,
            'category' => $category,
            'tagsCategory' => $tagsCategory,
            'tagsAll' => $tagsAll,
            'gamesCount' => $gamesCount,
            'gamesPublishCount' => $gamesPublishCount,
            'gamesUnpublishCount' => $gamesUnpublishCount,
            'tagsCount' => $tagsCount,
        ]);
    }

    /**
     * @TODO validation, create url
     * @param Category $Category
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function putCategory(Category $category, Request $request, UrlGenerator $urlGenerator)
    {
        //if category has displayed games
        $displayedGames = $category->game()->where('game_show', true)->get()->isNotEmpty();
        if ($category->display != $request->display && $request->display == false && $displayedGames) {
            throw new CategoryUpdateException('Нельзя сделать категорию не отображаемой когда в ней есть отображаемые игры');
        }

        if ($request->cat_rename) {
            $category->cat_name = $request->cat_rename;
            $category->cat_url = $urlGenerator->createUrl($category->cat_name);
        }
        $category->cat_order = $request->cat_order;
        $category->cat_desc = $request->cat_desc;
        $category->cat_title = $request->cat_title;
        $category->cat_desc_meta = $request->cat_desc_meta;
        $category->cat_key_meta = $request->cat_key_meta;

        if ($category->display != $request->display) {
            $category->display = $request->display;
        }
        $category->save();
        //dd($request->only('cat_order', 'cat_desc', 'cat_rename', 'cat_title', 'cat_desc_meta',
        //    'cat_key_meta', 'cat_h1', 'cat_desc'));
        //dd($Category, $request);
        return redirect()->route('admin.getCategory', [$category]);
    }

    //TODO delete category, and game category
    public function deleteCategory(Category $category)
    {
        $displayedGames = $category->game()->where('game_show', true)->get()->isNotEmpty();
        if ($displayedGames) {
            throw new CategoryUpdateException('Нельзя удалить категорию когда в ней есть отображаемые игры');
        }
        $category->game()->update(['category_id' => false]);
        $category->delete();
        return redirect('admin');

    }
}
