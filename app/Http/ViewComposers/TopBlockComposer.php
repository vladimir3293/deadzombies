<?php


namespace Deadzombies\Http\ViewComposers;


use Deadzombies\Model\Category;
use Illuminate\View\View;

class TopBlockComposer
{
    public $category;

    public function __construct(Category $category)
    {
        $this->category = $category;
    }

    public function compose(View $view)
    {
        $categories = $this->category->where('display',true)->orderBy('cat_order')->get();
        $categories->each(function ($value) {
            $value->url = route('getCategory', ['cat' => $value->cat_url], false);
        });
        $view->with('categories', $categories);
    }
}