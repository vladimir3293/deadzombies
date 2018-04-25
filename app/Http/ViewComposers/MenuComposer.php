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
        $categories = $this->category->orderBy('cat_order')->get();
//dd($categories);
        $categories->each(function ($value) {
            $value->url = route('getCategory', ['cat' => $value->cat_url],false);
        });
        $view->with('menu', $categories);
    }
}