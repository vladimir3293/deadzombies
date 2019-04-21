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
    public function getPage(Page $page)
    {
        return view('admin.pages.page', [
            'page' => $page,
        ]);
    }

    /**
     * @TODO validation, create url
     * @param Category $Category
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function putPage(Page $page, Request $request)
    {
        $page->title = $request->title;
        $page->desc_meta = $request->desc_meta;
        $page->desc_key = $request->desc_key;
        $page->description = $request->description;
        $page->h1 = $request->h1;
        $page->save();
        return redirect()->back();
    }
}
