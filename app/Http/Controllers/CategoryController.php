<?php


namespace Deadzombies\Http\Controllers;


use Deadzombies\Model\Category;

class CategoryController extends Controller
{
    public function getMenuCategory()
    {
        $category = new Category();
        $cat = $category::orderBy('cat_order')->get();
        $cats = $cat->each(function ($item) {
            $result[] =['cat_name'=>$item->cat_name,
            'cat_url'=>$item->cat_url];
            //echo $item->cat_url;
        });
        echo '122122112';
//svar_dump($cat);
        return ['foo','bar','baz'];
    }
}