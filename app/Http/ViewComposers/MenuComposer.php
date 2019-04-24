<?php

namespace Deadzombies\Http\ViewComposers;


use Deadzombies\Model\Category;
use Illuminate\View\View;

class MenuComposer
{
    public $category;

    public function __construct(Category $category)
    {
        $this->category = $category;
    }

    public function compose(View $view)
    {
        $categories = $this->category->where('display', 1)->orderBy('cat_order')->get();
        $categories->each(function ($category) {
            $value->url = route('getCategory', ['cat' => $category->cat_url], false);
            $mainImg = $category->image()->where('main_img', true)->get()->first();
            if (!empty($mainImg)) {
                $category->img = "/img/$mainImg->name.jpg";
            } else {
                $category->img = '/img/site/empty.jpg';
            }
        });
        $view->with('menu', $categories);
    }
}