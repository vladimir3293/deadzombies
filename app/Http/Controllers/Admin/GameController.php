<?php

namespace Deadzombies\Http\Controllers\Admin;

use Deadzombies\Model\Category;
use Deadzombies\Model\Game;
use Illuminate\Http\Request;
use Deadzombies\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;

//use Illuminate\Support\Facades\Storage;

class GameController extends Controller
{
    public function getGame(Game $Game, Category $category)
    {
        $categories = $category::all();
        $Game->cat = $Game->category ? $Game->category->cat_name : 'НЕТ';
        $Game->flash = Storage::disk('pub')->exists("/games/$Game->game_url.swf") ? 'ЕСТЬ' : 'НЕТ';
        $Game->img1 = Storage::disk('pub')->exists("/img/$Game->game_url.jpg") ? 'ЕСТЬ' : 'НЕТ';
        $Game->img2 = Storage::disk('pub')->exists("/img/$Game->game_url-second.jpg") ? 'ЕСТЬ' : 'НЕТ';
        $Game->img3 = Storage::disk('pub')->exists("/img/$Game->game_url-third.jpg") ? 'ЕСТЬ' : 'НЕТ';
        return view('admin.game', ['game' => $Game, 'categories' => $categories]);
    }

    public function putGame(Game $Game, Request $request)
    {
        //TODO if show check category, and if delete cat
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
        if (null !== $request->file('flash')) {
            //dd($request->file('flash'));
            $request->file('flash')->storeAs('/games', $Game->game_url . '.swf', 'pub');
            $size = getimagesize(public_path("/games/$Game->game_url.swf"));
            $size = $size[0] / $size[1];
            $Game->game_size = $size;
        }


        if (null !== $request->file('img1')) {
            $this->createImage($Game->game_url, $request->file('img1'));
        }

        if (null !== $request->file('img2')) {
            $this->createImage($Game->game_url, $request->file('img2'), '-second');
        }

        if (null !== $request->file('img3')) {
            $this->createImage($Game->game_url, $request->file('img3'), '-third');
        }

        //TODO rename flash and img
        if ($request->game_rename) {
            $Game->game_name = $request->game_rename;
            $newUrl = $this->create_url($Game->game_name);

            if (Storage::disk('pub')->exists("/games/$Game->game_url.swf")) {
                Storage::disk('pub')->move("/games/$Game->game_url.swf", "/games/$newUrl.swf");
            }

            if (Storage::disk('pub')->exists("/img/$Game->game_url.jpg")) {
                Storage::disk('pub')->move("/img/$Game->game_url.jpg", "/img/$newUrl.jpg");
                Storage::disk('pub')->move("/img/$Game->game_url-small.jpg", "/img/$newUrl-small.jpg");
                Storage::disk('pub')->move("/img/$Game->game_url-large.jpg", "/img/$newUrl-large.jpg");
            }

            if (Storage::disk('pub')->exists("/img/$Game->game_url-second.jpg")) {
                Storage::disk('pub')->move("/img/$Game->game_url-second.jpg", "/img/$newUrl-second.jpg");
                Storage::disk('pub')->move("/img/$Game->game_url-second-small.jpg", "/img/$newUrl-second-small.jpg");
                Storage::disk('pub')->move("/img/$Game->game_url-second-large.jpg", "/img/$newUrl-second-large.jpg");
            }

            if (Storage::disk('pub')->exists("/img/$Game->game_url-third.jpg")) {
                Storage::disk('pub')->move("/img/$Game->game_url-third.jpg", "/img/$newUrl-third.jpg");
                Storage::disk('pub')->move("/img/$Game->game_url-third-small.jpg", "/img/$newUrl-third-small.jpg");
                Storage::disk('pub')->move("/img/$Game->game_url-third-large.jpg", "/img/$newUrl-third-large.jpg");
            }

            $Game->game_url = $this->create_url($Game->game_name);

        }

        $Game->save();
        return redirect()->route('admin.getGame', [$Game]);
    }

    public function deleteGame(Game $Game)
    {
        if (Storage::disk('pub')->exists("/games/$Game->game_url.swf")) {
            Storage::disk('pub')->delete("/games/$Game->game_url.swf");
        }

        if (Storage::disk('pub')->exists("/img/$Game->game_url.jpg")) {
            Storage::disk('pub')->delete([
                "/img/$Game->game_url.jpg",
                "/img/$Game->game_url-small.jpg",
                "/img/$Game->game_url-large.jpg"
            ]);
        }

        if (Storage::disk('pub')->exists("/img/$Game->game_url-second.jpg")) {
            Storage::disk('pub')->delete([
                "/img/$Game->game_url-second.jpg",
                "/img/$Game->game_url-second-small.jpg",
                "/img/$Game->game_url-second-large.jpg"
            ]);
        }

        if (Storage::disk('pub')->exists("/img/$Game->game_url-third.jpg")) {
            Storage::disk('pub')->delete([
                "/img/$Game->game_url-third-.jpg",
                "/img/$Game->game_url-third-small.jpg",
                "/img/$Game->game_url-third-large.jpg"
            ]);
        }

        $Game->delete();
        return redirect('admin');
    }

    public function createImage(string $url, $img, string $imgPrefix = '')
    {
        $old_size = getimagesize($img);

        $small_size = imagecreatetruecolor(80, 56);
        $medium_size = imagecreatetruecolor(220, 153);
        $large_size = imagecreatetruecolor(385, 268);

        $original = imagecreatefromjpeg($img);

        imagecopyresampled($small_size, $original, 0, 0, 0, 0, 80, 56, $old_size[0], $old_size[1]);
        imagecopyresampled($medium_size, $original, 0, 0, 0, 0, 220, 153, $old_size[0], $old_size[1]);
        imagecopyresampled($large_size, $original, 0, 0, 0, 0, 385, 268, $old_size[0], $old_size[1]);

        imagejpeg($small_size, public_path("/img/$url$imgPrefix-small.jpg"));
        imagejpeg($medium_size, public_path("/img/$url$imgPrefix.jpg"));
        imagejpeg($large_size, public_path("/img/$url$imgPrefix-large.jpg"));
    }

//TODO wtf, where must save it

    public function create_url($url)
    {
        //var_dump($url);
        $url = mb_strtolower($url, 'UTF-8');    #переводит все буквы в нижний регистр
        //var_dump($url);
        $rus = array('а', 'б', 'в', 'г', 'д', 'е', 'ё', 'ж', 'з', 'и', 'й', 'к', 'л', 'м', 'н', 'о', 'п', 'р', 'с', 'т', 'у', 'ф', 'х', 'ц', 'ч', 'ш', 'щ', 'ъ', 'ы', 'ь', 'э', 'ю', 'я');
        $eng = array('a', 'b', 'v', 'g', 'd', 'e', 'e', 'zh', 'z', 'i', 'i', 'k', 'l', 'm', 'n', 'o', 'p', 'r', 's', 't', 'u', 'f', 'kh', 'ts', 'ch', 'sh', 'shch', 'ie', 'y', '', 'e', 'iu', 'ia',);
        $url = str_replace($rus, $eng, $url);
        $url = str_replace(' ', '-', $url);            #заменяет пробелы на дефис
        #$createurl=stripcslashes($createurl);

        return $url;
    }

}
