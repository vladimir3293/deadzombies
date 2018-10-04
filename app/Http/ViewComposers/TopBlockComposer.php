<?php


namespace Deadzombies\Http\ViewComposers;


use Deadzombies\Model\Category;
use Illuminate\Database\Eloquent\Collection;
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
        $topCategories = $this->category->where('display',true)->limit(5)->get();
        $topCategories->each(function ($category) {
            $category->url = route('getCategory', ['cat' => $category->cat_url], false);
            $category->img = file_exists(public_path() . '/img/categories/' . $category->cat_url . '.jpg') ?
                '/img/categories/' . $category->cat_url . '.jpg' :
                '/img/site/empty.jpg';
        });
        $popularCategories = $this->category->where('display',true)->limit(5)->get();
        $popularCategories->each(function ($category) {
            $category->url = route('getCategory', ['cat' => $category->cat_url], false);
            $category->img = file_exists(public_path() . '/img/categories/' . $category->cat_url . '.jpg') ?
                '/img/categories/' . $category->cat_url . '.jpg' :
                '/img/site/empty.jpg';
        });
        $view->with([
            'categories'=> $categories,
            'topCategories'=>$topCategories,
            'popularCategories'=>$popularCategories,
        ]);
    }
}