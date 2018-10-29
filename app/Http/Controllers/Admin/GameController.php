<?php

namespace Deadzombies\Http\Controllers\Admin;

use Deadzombies\Exceptions\GameUpdateException;
use Deadzombies\Exceptions\TagDuplicateException;
use Deadzombies\Model\Category;
use Deadzombies\Model\Game;
use Deadzombies\Model\Tag;
use Deadzombies\UrlGenerator\UrlGenerator;
use Illuminate\Http\Request;
use Deadzombies\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;

//use Illuminate\Support\Facades\Storage;

class GameController extends Controller
{
    public function getAll(Game $gameModel)
    {
        $gamesCount = $gameModel->get()->count();
        $games = $gameModel->orderBy('id', 'desc')->paginate(24);
        //dd($games);
        $games->each(function ($games) {
            $games->url = route('admin.getGame', $games->game_url);
            $games->img = file_exists(public_path() . '/img/' . $games->game_url . '.jpg') ?
                '/img/' . $games->game_url . '.jpg' :
                '/img/site/empty.jpg';
        });
        return view('admin.game.gameAll', ['games' => $games, 'gamesCount' => $gamesCount]);
    }

    public function createGame()
    {
        return view('admin.game.createGame');
    }

//TODO create name
    public function postGame(Request $request, Game $Game, UrlGenerator $urlGenerator)
    {
        $Game->game_name = $request->create_game;
        $Game->game_url = $urlGenerator->createUrl($request->create_game);
        //dd($Game);
        //dd($Game->game_url);
        $Game->save();

        return redirect()->route('admin.getGame', [$Game]);
    }

    public function getUnpublished(Game $gameModel)
    {
        $gamesCount = $gameModel->where('game_show', 0)->get()->count();
        $games = $gameModel->where('game_show', 0)->orderBy('id', 'desc')->simplePaginate(12);
        //dd($games);
        $games->each(function ($games) {
            $games->url = route('admin.getGame', $games->game_url);
            $games->img = file_exists(public_path() . '/img/' . $games->game_url . '.jpg') ?
                '/img/' . $games->game_url . '.jpg' :
                '/img/site/empty.jpg';
        });
        return view('admin.game.unpublished', ['games' => $games, 'gamesCount' => $gamesCount]);
    }

    public function getPublished(Game $gameModel)
    {
        $gamesCount = $gameModel->where('game_show', 1)->get()->count();
        $games = $gameModel->where('game_show', 1)->orderBy('id', 'desc')->simplePaginate(48);
        //dd($games);
        $games->each(function ($games) {
            $games->url = route('admin.getGame', $games->game_url);
            $games->img = file_exists(public_path() . '/img/' . $games->game_url . '.jpg') ?
                '/img/' . $games->game_url . '.jpg' :
                '/img/site/empty.jpg';
        });
        return view('admin.game.published', ['games' => $games]);
    }

    public function getGame(Game $Game, Category $category, Tag $tagModel)
    {
        $tagsAll = $tagModel->orderBy('id', 'desc')->get();
        $tagsGame = $Game->tags()->orderBy('id', 'desc')->get();
        $categories = $category->orderBy('id', 'desc')->get();

        $Game->cat = $Game->category ? '<a href="' . route('admin.getCategory', [$Game->category->cat_url]) . '">' . $Game->category->cat_name . '</a>' : 'НЕТ';
        //$Game->flash = Storage::disk('pub')->exists("/games/$Game->game_url.swf") ? 'ЕСТЬ' : 'НЕТ';
        $Game->imgExist = Storage::disk('pub')->exists("/img/$Game->game_url.jpg") ? 'ЕСТЬ' : 'НЕТ';

        if ($Game->height) {
            $Game->gameHeight = 868 * $Game->height / $Game->width;
        }

        return view('admin.game.game', [
            'game' => $Game,
            'categories' => $categories,
            'tagsAll' => $tagsAll,
            'tagsGame' => $tagsGame
        ]);
    }

    public function postGameTag(Game $game, Request $request, Tag $tagModel)
    {
        if ($game->tags()->where('tags.id', $request->tagId)->get()->isNotEmpty()) {
            throw new TagDuplicateException('Такой тег уже присвоен игре');
        }

        $tag = $tagModel->where('id', $request->tagId)->get();
        $tag = $tag->first();
        //dd($Game, $request);
        $game->tags()->save($tag);
        return redirect()->route('admin.getGame', [$game]);
    }

    public function deleteGameTag(Game $Game, Request $request, Tag $tagModel)
    {
        $tag = $tagModel->where('id', $request->tagId)->get();
        //dd($tag);
        $Game->tags()->detach($tag);
        return redirect()->route('admin.getGame', [$Game]);
    }

    public function putGame(Game $Game, Category $category, Request $request, UrlGenerator $urlGenerator)
    {
        $Game->game_title = $request->game_title;
        $Game->game_desc_meta = $request->game_desc_meta;
        $Game->game_key_meta = $request->game_key_meta;
        $Game->game_desc = $request->game_desc;
        $Game->game_control = $request->game_control;
        $Game->source = $request->source;
        $Game->height = $request->height;
        $Game->width = $request->width;
        $Game->save();
        //TODO exception

        if ($Game->game_show != $request->game_show) {
            if ($request->game_cat && $request->game_show) {
                $newCategory = $category->where(['id' => $request->game_cat])->get()->first();
                if (!$newCategory->display && $request->game_show) {
                    throw new GameUpdateException('Нельзя отобразить игру в неотображаемой категории');
                }
                $Game->category_id = $request->game_cat;
            }
            if (!$Game->category && $request->game_show) {
                throw new GameUpdateException('Нельзя отобразить игру без категории');
            } else {
                if (!$Game->category->display && $request->game_show) {
                    throw new GameUpdateException('Нельзя отобразить игру в неотображаемой категории');
                }
            }
            $Game->game_show = $request->game_show;
        }

        if ($request->game_cat) {
            $newCategory = $category->where(['id' => $request->game_cat])->get()->first();
            if (!$newCategory->display && $Game->game_show) {
                throw new GameUpdateException('Нельзя присвоить неотоброжаемой категорию к отображаемой игре');
            }
            $Game->category_id = $request->game_cat;
        }

        if ($request->del_cat && $Game->game_show == true) {
            throw new GameUpdateException('Нельзя удалить категорию у отображаемой игры');
        }
        if ($request->del_cat) {
            $Game->category_id = null;
        }
        if (null !== $request->file('img')) {
            $this->createImage($Game->game_url, $request->file('img'));
        }
        //TODO rename img
        if ($request->game_rename) {
            $Game->game_name = $request->game_rename;
            $newUrl = $urlGenerator->createUrl($Game->game_name);
            /*
                        if (Storage::disk('pub')->exists("/games/$Game->game_url.swf")) {
                            Storage::disk('pub')->move("/games/$Game->game_url.swf", "/games/$newUrl.swf");
                        }
            */
            if (Storage::disk('pub')->exists("/img/$Game->game_url.jpg")) {
                Storage::disk('pub')->move("/img/$Game->game_url.jpg", "/img/$newUrl.jpg");
            }
            if (Storage::disk('pub')->exists("/img/$Game->game_url-small.jpg")) {
                Storage::disk('pub')->move("/img/$Game->game_url-small.jpg", "/img/$newUrl-small.jpg");
            }
            if (Storage::disk('pub')->exists("/img/$Game->game_url-large.jpg")) {
                Storage::disk('pub')->move("/img/$Game->game_url-large.jpg", "/img/$newUrl-large.jpg");
            }

            $Game->game_url = $newUrl;
            //dd($newUrl);
        }

        $Game->save();
        return redirect()->route('admin.getGame', [$Game]);
    }

    public function deleteGame(Game $Game)
    {

        if (Storage::disk('pub')->exists("/img/$Game->game_url.jpg")) {
            Storage::disk('pub')->delete(["/img/$Game->game_url.jpg"]);
        }
        if (Storage::disk('pub')->exists("/img/$Game->game_url-small.jpg")) {
            Storage::disk('pub')->delete(["/img/$Game->game_url-small.jpg"]);
        }
        if (Storage::disk('pub')->exists("/img/$Game->game_url-large.jpg")) {
            Storage::disk('pub')->delete(["/img/$Game->game_url-large.jpg"]);
        }

        $Game->delete();
        return redirect('admin');
    }

//TODO WTFFFFF
    public function createImage(string $url, $img, string $imgPrefix = '')
    {
        $old_size = getimagesize($img);

        $small_size = imagecreatetruecolor(80, 56);
        $medium_size = imagecreatetruecolor(220, 153);
        $large_size = imagecreatetruecolor(770, 536);

        $original = imagecreatefromjpeg($img);

        imagecopyresampled($small_size, $original, 0, 0, 0, 0, 80, 56, $old_size[0], $old_size[1]);
        imagecopyresampled($medium_size, $original, 0, 0, 0, 0, 220, 153, $old_size[0], $old_size[1]);
        imagecopyresampled($large_size, $original, 0, 0, 0, 0, 770, 536, $old_size[0], $old_size[1]);

        imagejpeg($small_size, public_path("/img/$url$imgPrefix-small.jpg"));
        imagejpeg($medium_size, public_path("/img/$url$imgPrefix.jpg"));
        imagejpeg($large_size, public_path("/img/$url$imgPrefix-large.jpg"));
    }
}