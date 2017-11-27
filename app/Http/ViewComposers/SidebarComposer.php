<?php

namespace Deadzombies\Http\ViewComposers;


use Deadzombies\Model\Category;
//use Illuminate\Support\Facades\Request;
use Illuminate\Http\Request;
use Illuminate\View\View;

class SidebarComposer
{
    public $category;

    public $request;

    public function __construct(Category $category, Request $request)
    {
        $this->category = $category;
        $this->request = $request;
    }

    public function compose(View $view)
    {
//dd($this->request->path());

        if ($this->request->is('category/*')){
            echo '1221';
        }
        if($this->request->is('/')){
            echo 'koren';
        }
            $categories = $this->category::orderBy('cat_order')->get();
        $categories->each(function ($value) {
            $value->url = route('getCat', ['cat' => $value->cat_url]);
        });
        $view->with('menu', $categories);
    }
}