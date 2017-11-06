<?php

namespace Deadzombies\Http\Controllers\Admin;

use Deadzombies\Model\Category;
use Deadzombies\Model\Game;
use Illuminate\Http\Request;
use Deadzombies\Http\Controllers\Controller;

class GameController extends Controller
{
    public function getGame(Game $Game, Category $category)
    {
        $categories = $category::all();
        $Game->cat = $Game->category ? $Game->category->cat_name : 'НЕТ';
        $Game->flash = file_exists(public_path("/games/$Game->game_url.swf")) ? 'ЕСТЬ' : 'НЕТ';
        $Game->img = file_exists(public_path("/img/$Game->game_url-first.swf")) ? 'ЕСТЬ' : 'НЕТ';
        $Game->img = file_exists(public_path("/games/$Game->game_url-second.swf")) ? 'ЕСТЬ' : 'НЕТ';
        $Game->img = file_exists(public_path("/games/$Game->game_url-third.swf")) ? 'ЕСТЬ' : 'НЕТ';
        return view('game', ['game' => $Game, 'categories' => $categories]);
    }

    public function putGame(Game $Game, Request $request)
    {
        if ($request->game_rename) {
            $Game->game_name = $request->game_rename;
            $Game->game_url = $this->create_url($Game->game_name);
        }
        $Game->game_title = $request->game_title;
        $Game->game_desc_meta = $request->game_desc_meta;
        $Game->game_key_meta = $request->game_key_meta;
        $Game->game_desc = $request->game_desc;
        $Game->game_control = $request->game_control;
        if ($request->game_cat) {
            $Game->game_cat = $request->game_cat;
        }
        if ($request->del_cat) {
            $Game->game_cat = null;
        }
        if ($Game->game_show != $request->game_show) {
            $Game->game_show = $request->game_show;
        }
//TODO  game size
        if (null !== $request->file('flash')) {
            $request->file('flash')->storeAs('/games', $Game->game_url . '.swf', 'pub');
        }
        $Game->save();
        return redirect()->route('admin.getGame', [$Game]);
    }

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
