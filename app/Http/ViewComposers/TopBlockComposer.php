<?php


namespace Deadzombies\Http\ViewComposers;


use Deadzombies\Model\Category;
use Deadzombies\Model\Image;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\View\View;

class TopBlockComposer
{
    public $category;

    public $imageModel;

    public function __construct(Category $category, Image $imageModel)
    {
        $this->category = $category;
        $this->imageModel = $imageModel;
    }

    public function compose(View $view)
    {
        $categories = $this->imageModel->makeCategoryImgUrl(
            $this->category
                ->where('display', true)
                ->orderBy('cat_order')
                ->get()
        );

        $topCategories = $this->category->where('display', true)->limit(5)->get();
        $topCategories->each(function ($category) {
            $category->url = route('getCategory', ['cat' => $category->cat_url], false);
            //TODO delete dublicate
            $mainImg = $category->image()->where('main_img', true)->get()->first();
            if (!empty($mainImg)) {
                $category->img = "/img/$mainImg->name.jpg";
                $category->imgAlt = $mainImg->alt;
                $category->imgTitle = $mainImg->title;
            } elseif (file_exists(public_path() . '/img/' . $category->cat_url . '.jpg')) {
                $category->img = '/img/' . $category->cat_url . '.jpg';
                $category->imgAlt = $category->cat_title;
                $category->imgTitle = $category->cat_title;

            } else {
                $category->img = '/img/site/empty.jpg';
                $category->imgAlt = 'пустое изображение';
                $category->imgTitle = 'пустое изображение';
            }
        });
        $popularCategories = $this->category->where('display', true)->limit(5)->get();
        $popularCategories->each(function ($category) {
            $category->url = route('getCategory', ['cat' => $category->cat_url], false);
            //TODO delete dublicate
            $mainImg = $category->image()->where('main_img', true)->get()->first();
            if (!empty($mainImg)) {
                $category->img = "/img/$mainImg->name.jpg";
                $category->imgAlt = $mainImg->alt;
                $category->imgTitle = $mainImg->title;
            } elseif (file_exists(public_path() . '/img/' . $category->cat_url . '.jpg')) {
                $category->img = '/img/' . $category->cat_url . '.jpg';
                $category->imgAlt = $category->cat_title;
                $category->imgTitle = $category->cat_title;

            } else {
                $category->img = '/img/site/empty.jpg';
                $category->imgAlt = 'пустое изображение';
                $category->imgTitle = 'пустое изображение';
            }
        });
        $view->with([
            'categories' => $categories,
            'topCategories' => $topCategories,
            'popularCategories' => $popularCategories,
        ]);
    }
}