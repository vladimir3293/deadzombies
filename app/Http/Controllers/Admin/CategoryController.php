<?php

namespace Deadzombies\Http\Controllers\Admin;

use Deadzombies\Model\Category;
use Deadzombies\Model\Game;
use Deadzombies\Model\Tag;
use Deadzombies\UrlGenerator\UrlGenerator;
use Illuminate\Http\Request;
use Deadzombies\Http\Controllers\Controller;

class CategoryController extends Controller
{
    public function postCategoryTag(Category $Category, Request $request, Tag $tagModel)
    {
        $tag = $tagModel->where('id', $request->tagId)->get()->first();
        //dd($Game, $request);
        $Category->tags()->save($tag);
        return redirect()->route('admin.getCategory', [$Category],false);
    }

    public function deleteCategoryTag(Category $Category, Request $request, Tag $tagModel)
    {
        $tag = $tagModel->where('id', $request->tagId)->get();
        //dd($tag);
        $Category->tags()->detach($tag);
        return redirect()->route('admin.getCategory', [$Category],false);
    }

    public function createCategory()
    {
        return view('admin.createCategory');
    }

    public function postCategory(Request $request, Category $category, UrlGenerator $urlGenerator)
    {
        $category->cat_name = $request->create_category;
        $category->cat_url = $urlGenerator->createUrl($request->create_category);
        //dd($Game);
        //dd($Game->game_url);
        $category->save();

        return redirect()->route('admin.getCategory', [$category],false);
    }

    //todo only show games
    public function getCategory(Category $Category, Game $game, Tag $tagModel)
    {
        $tagsAll = $tagModel->orderBy('id', 'desc')->get();
        $tagsCategory = $Category->tags()->orderBy('id', 'desc')->get();
        $games = $game->where('category_id', $Category->id)->paginate(12);
        foreach ($games as $game) {
            $game->url = route('admin.getGame', $game->game_url,false);
            $game->img = file_exists(public_path() . '/img/' . $game->game_url . '.jpg') ?
                '/img/' . $game->game_url . '.jpg' :
                '/img/empty.jpg';
        }
        return view('admin.category', [
            'games' => $games,
            'category' => $Category,
            'tagsCategory' => $tagsCategory,
            'tagsAll' => $tagsAll
        ]);
    }

    /**
     * @TODO validation, create url
     * @param Category $Category
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function putCategory(Category $Category, Request $request, UrlGenerator $urlGenerator)
    {
        if ($request->cat_rename) {
            $Category->cat_name = $request->cat_rename;
            $Category->cat_url = $urlGenerator->createUrl($Category->cat_name);
        }
        $Category->cat_order = $request->cat_order;
        $Category->cat_desc = $request->cat_desc;
        $Category->cat_title = $request->cat_title;
        $Category->cat_desc_meta = $request->cat_desc_meta;
        $Category->cat_key_meta = $request->cat_key_meta;
        $Category->save();
        //dd($request->only('cat_order', 'cat_desc', 'cat_rename', 'cat_title', 'cat_desc_meta',
        //    'cat_key_meta', 'cat_h1', 'cat_desc'));
        //dd($Category, $request);
        return redirect()->route('admin.getCategory', [$Category]);
    }

    public function deleteCategory(Category $Category)
    {
        //TODO delete category, and game category
        $Category->delete();
        return redirect('admin');

    }
}
