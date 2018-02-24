<?php

namespace Deadzombies\Http\Controllers\Admin;

use Deadzombies\Model\Category;
use Deadzombies\Model\Game;
use Illuminate\Http\Request;
use Deadzombies\Http\Controllers\Controller;

class CategoryController extends Controller
{
    //todo only show games
    public function getCategory(Category $Category, Game $game)
    {
        $games = $game->where('category_id', $Category->id)->simplePaginate(3);
        foreach ($games as $game) {
            $game->url = route('admin.getGame', $game->game_url);
            $game->img = file_exists(public_path() . '/img/' . $game->game_url . '.jpg') ?
                '/img/' . $game->game_url . '.jpg' :
                '/img/empty.jpg';
        }
        return view('admin.category', ['games' => $games, 'category' => $Category]);
    }

    /**
     * @TODO validation, create url
     * @param Category $Category
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function putCategory(Category $Category, Request $request)
    {
        if ($request->cat_rename) {
//            dd($request);
            $Category->cat_name = $request->cat_rename;
            $Category->cat_url = $this->create_url($Category->cat_name);
            //dd($Category);

        }
        $Category->cat_order = $request->cat_order;
        $Category->cat_desc = $request->cat_desc;
        $Category->cat_title = $request->cat_title;
        $Category->cat_desc_meta = $request->cat_desc_meta;
        $Category->cat_key_meta = $request->cat_key_meta;
        $Category->cat_h1 = $request->cat_h1;
        $Category->save();
        //dd($request->only('cat_order', 'cat_desc', 'cat_rename', 'cat_title', 'cat_desc_meta',
        //    'cat_key_meta', 'cat_h1', 'cat_desc'));
        //dd($Category, $request);
        return redirect()->route('admin.getCat', [$Category]);
    }

    public function deleteCategory(Category $Category)
    {
        //TODO delete category, and game category
        dd($Category);
    }

    /**
     * @TODO fix it
     * @param $name
     * @return mixed|string
     */
    public function create_name($name)
    {
        $name = trim($name);    #обрезает пробелы в конце и начале, должна еще и спецсимволы, но что-то через один
        $name = preg_replace('/  +/', ' ', $name);
        $del = array('~', '!', '@', '#', '%', '^', '&', '*', '(', ')', '_', '+', '=', '`', ',', '.', '/', '<', '>', '{', '}', '[', ']', ';', '\'', '\\', ':', '"', '|', '№', '$', '«', '»', '"');
        $name = str_replace($del, '', $name);
        return $name;
    }

    /**
     * @TODO fix
     */
    public function create_url($url)
    {
        var_dump($url);
        $url = mb_strtolower($url, 'UTF-8');    #переводит все буквы в нижний регистр
        var_dump($url);
        $rus = array('а', 'б', 'в', 'г', 'д', 'е', 'ё', 'ж', 'з', 'и', 'й', 'к', 'л', 'м', 'н', 'о', 'п', 'р', 'с', 'т', 'у', 'ф', 'х', 'ц', 'ч', 'ш', 'щ', 'ъ', 'ы', 'ь', 'э', 'ю', 'я');
        $eng = array('a', 'b', 'v', 'g', 'd', 'e', 'e', 'zh', 'z', 'i', 'i', 'k', 'l', 'm', 'n', 'o', 'p', 'r', 's', 't', 'u', 'f', 'kh', 'ts', 'ch', 'sh', 'shch', 'ie', 'y', '', 'e', 'iu', 'ia',);
        $url = str_replace($rus, $eng, $url);
        $url = str_replace(' ', '-', $url);            #заменяет пробелы на дефис
        #$createurl=stripcslashes($createurl);

        return $url;
    }


}
