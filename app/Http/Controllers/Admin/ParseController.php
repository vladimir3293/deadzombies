<?php

namespace Deadzombies\Http\Controllers\Admin;

use Deadzombies\Model\Category;
use Deadzombies\Model\Game;
use Deadzombies\Parser\Parser;
use Deadzombies\UrlGenerator\UrlGenerator;
use Illuminate\Contracts\Filesystem\Filesystem;
use Illuminate\Http\Request;
use Deadzombies\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;

class ParseController extends Controller
{
    public function getParser(\Deadzombies\Model\Tag $tagModel, Parser $parser, Category $categoryModel,
                              Game $gameModel, UrlGenerator $urlGenerator, Filesystem $filesystem)
    {
        $onePageUrl = $parser->getGamesUrls(2);
        $onePageUrlTest[] = $onePageUrl[0];
        $onePageUrlTest[] = $onePageUrl[1];
        $onePageUrlTest[] = $onePageUrl[2];
        $onePageUrlTest[] = $onePageUrl[3];
        foreach ($onePageUrlTest as $oneGame) {
            $oneGameData = $parser->getGame($oneGame);
            $game = $gameModel->where('game_url', $urlGenerator->urlCreate($oneGameData['name']))->get();
            if ($game->isEmpty()) {
                //dd(file_get_contents('https:' . $oneGameData['img']));
                //TODO filesystem
                Storage::disk('pub')->put(
                    '/img/' . $urlGenerator->urlCreate($oneGameData['name']) . '.jpg',
                    file_get_contents('https:' . $oneGameData['img'])
                );
                //dd($filesystem->);
                $createdGame = $gameModel->create([
                    'game_name' => $oneGameData['name'],
                    'game_url' => $urlGenerator->urlCreate($oneGameData['name']),
                    'game_desc' => $oneGameData['desc'],
                    'game_title' => $oneGameData['name'],
                    'game_desc_meta' => $oneGameData['name'],
                    'game_key_meta' => $oneGameData['name'],
                    'game_control' => 'mouse keyboard',
                    'source' => $oneGameData['url'],
                    'img' => $oneGameData['img'],
                    'width' => $oneGameData['width'],
                    'height' => $oneGameData['height'],
                    //'category' => $oneGameData['cat']
                ]);
                if (!empty($oneGameData['tags'])) {
                    $tagId = [];
                    foreach ($oneGameData['tags'] as $tag) {
                        $testTag = $tagModel->firstOrCreate(['name' => mb_strtolower($tag, "UTF-8")],
                            ['name' => mb_strtolower($tag, "UTF-8"), 'url' => $urlGenerator->urlCreate($tag)]);
                        $tagId[] = $testTag->id;
                    }
                    //    dd($tagId);
                }
                $createdGame->tags()->attach($tagId);

                $category = $categoryModel->firstOrCreate(
                    ['cat_url' => $urlGenerator->urlCreate($oneGameData['cat'])],
                    [
                        'cat_name'=>$oneGameData['cat'],
                        'cat_url' => $urlGenerator->urlCreate($oneGameData['cat']),
                        'cat_desc' => 'standard',
                        'cat_h1' => 'standard',
                        'cat_title' => 'standart'
                    ]);

                $category->game()->save($createdGame);
                //dd($category,$createdGame);
            }
        }
        return view('admin.parser');
    }
}
