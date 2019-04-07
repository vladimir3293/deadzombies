<?php

namespace Deadzombies\Http\Controllers\Admin;

use Deadzombies\Exceptions\CategoryUpdateException;
use Deadzombies\Exceptions\TagDuplicateException;
use Deadzombies\Model\Category;
use Deadzombies\Model\Game;
use Deadzombies\Model\Page;
use Deadzombies\Model\Tag;
use Deadzombies\UrlGenerator\UrlGenerator;
use Illuminate\Http\Request;
use Deadzombies\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;

class PagesController extends Controller
{
    public function getAll(Page $pageModel)
    {
        //$categoriesCount = $categoryModel->get()->count();
//        $categories = $categoryModel->simplePaginate(100);
        $pages = $pageModel->all();
//        dd($pages);
        $pages->each(function ($page) {
            $page->url = route('admin.pages.getPage', $page->url);
        });

        return view('admin.pages.all', ['pages' => $pages]);
    }


    //todo only show games
    //todo main img
    public function getPage(Page $page)
    {

        $page->imgExist = $page->image()->get();
        return view('admin.pages.page', [
            'page'=>$page,
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

        $category->cat_order = $request->cat_order;
        $category->cat_desc = $request->cat_desc;
        $category->cat_title = $request->cat_title;
        $category->cat_desc_meta = $request->cat_desc_meta;
        $category->cat_key_meta = $request->cat_key_meta;

        if ($category->display != $request->display) {
            $category->display = $request->display;
        }


        if (null !== $request->file('img')) {
            $this->createImage($category->cat_url, $request->file('img'));
        }

        if ($request->cat_rename) {
            $category->cat_name = $request->cat_rename;
            $newUrl = $urlGenerator->createUrl($category->cat_name);

            if (Storage::disk('pub')->exists("/img/categories/$category->cat_url.jpg")) {
                Storage::disk('pub')->move("/img/categories/$category->cat_url.jpg", "/img/categories/$newUrl.jpg");
            }
            if (Storage::disk('pub')->exists("/img/categories/$category->cat_url-small.jpg")) {
                Storage::disk('pub')->move("/img/categories/$category->cat_url-small.jpg", "/img/categories/$newUrl-small.jpg");
            }
            if (Storage::disk('pub')->exists("/img/categories/$category->cat_url-large.jpg")) {
                Storage::disk('pub')->move("/img/categories/$category->cat_url-large.jpg", "/img/categories/$newUrl-large.jpg");
            }
            $category->cat_url = $newUrl;
        }
        $category->save();
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

//WTFFFFFF
    public function createImage(string $url, $img, string $imgPrefix = '')
    {
        $old_size = getimagesize($img);

        $small_size = imagecreatetruecolor(80, 56);
        $medium_size = imagecreatetruecolor(220, 153);
        $large_size = imagecreatetruecolor(385, 268);

        $original = imagecreatefromjpeg($img);

        imagecopyresampled($small_size, $original, 0, 0, 0, 0, 80, 56, $old_size[0], $old_size[1]);
        imagecopyresampled($medium_size, $original, 0, 0, 0, 0, 220, 153, $old_size[0], $old_size[1]);
        imagecopyresampled($large_size, $original, 0, 0, 0, 0, 385, 268, $old_size[0], $old_size[1]);

        imagejpeg($small_size, public_path("/img/categories/$url$imgPrefix-small.jpg"));
        imagejpeg($medium_size, public_path("/img/categories/$url$imgPrefix.jpg"));
        imagejpeg($large_size, public_path("/img/categories/$url$imgPrefix-large.jpg"));
    }
}
