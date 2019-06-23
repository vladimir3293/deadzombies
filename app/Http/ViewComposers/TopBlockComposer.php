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
                ->with(['image'
                => function ($query) {
                        $query->where('main_img', true)->first();
                    }])
                ->where('display', true)
                ->orderBy('cat_order')
                ->get()
        );

        $topCategories = $this->imageModel->makeCategoryImgUrl(
            $this->category
                ->with(['image'
                => function ($query) {
                        $query->where('main_img', true)->first();
                    }])
                ->where('display', true)
                ->orderBy('id', 'desc')
                ->limit(10)
                ->get()
        );

        $popularCategories = $this->imageModel->makeCategoryImgUrl(
            $this->category->with(['image'
            => function ($query) {
                    $query->where('main_img', true)->first();
                }])->where('display', true)
                ->limit(10)
                ->get()
        );

        $view->with([
            'categories' => $categories,
            'topCategories' => $topCategories,
            'popularCategories' => $popularCategories,
        ]);
    }
}