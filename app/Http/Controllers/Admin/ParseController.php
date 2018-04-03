<?php

namespace Deadzombies\Http\Controllers\Admin;

use Deadzombies\Model\Category;
use Deadzombies\Model\Game;
use Deadzombies\Model\Tag;
use Deadzombies\Parser\Parser;
use Deadzombies\UrlGenerator\UrlGenerator;
use Illuminate\Contracts\Filesystem\Filesystem;
use Illuminate\Http\Request;
use Deadzombies\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;

class ParseController extends Controller
{
    //TODO another parser
    public function getParser()
    {
        return view('admin.parser.gamedistribution');
    }
    //TODO img
    public function postGameDist(Request $request, Tag $tagModel, Parser $parser, Category $categoryModel,
                              Game $gameModel, UrlGenerator $urlGenerator, Filesystem $filesystem)
    {
        //get urls from one page
        $onePageRawUrl = collect($parser->getGamesUrls($request->page_number));

        //first verification for unique
        $pageUrls = [];
        foreach ($onePageRawUrl as $value) {
            //TODO WTF
            $pageUrls[] = $urlGenerator->createUrl(htmlspecialchars_decode(explode('.', explode('/', $value)[5])[0], ENT_QUOTES));
        }
        $pageUrls = collect($pageUrls);
        $existUrls = $gameModel->pluck('original_url');
        $onePageUrlTest = $pageUrls->diff($existUrls);

//        dd($onePageUrlTest);

        /*
                for ($i = 0; $i < 40; $i++) {
                    $onePageUrlTest[] = $onePageUrl[$i];
                }
                //dd($_SERVER);
        */
        ini_set('default_socket_timeout', 900);
//dd($onePageUrl[1]);
        $onePageUrl[] = $onePageUrlTest[6];
        dd($onePageUrlTest[6]);
//dd($onePageUrlTest);
          foreach ($onePageUrl as $oneGame) {
            //dd($oneGame);
            $oneGameData = $parser->getGame($oneGame);
            $game = $gameModel->where('game_url', $urlGenerator->createUrl($oneGameData['name']))->get();
            if ($game->isEmpty()) {
                //dd(file_get_contents('https:' . $oneGameData['img']));
                //TODO filesystem
                Storage::disk('pub')->put(
                    '/img/' . $urlGenerator->createUrl($oneGameData['name']) . '.jpg',
                    file_get_contents($oneGameData['img'])
                );
                //dd($filesystem->);
                $createdGame = $gameModel->create([
                    'game_name' => $oneGameData['name'],
                    'game_url' => $urlGenerator->createUrl($oneGameData['name']),
                    'game_desc' => $oneGameData['desc'],
                    'game_title' => $oneGameData['name'],
                    'game_desc_meta' => $oneGameData['name'],
                    'game_key_meta' => $oneGameData['name'],
                    'game_control' => 'mouse keyboard',
                    'source' => $oneGameData['url'],
                    'img' => $oneGameData['img'],
                    'width' => $oneGameData['width'],
                    'height' => $oneGameData['height'],
                    'original_url' => $oneGameData['original_url']
                    //'category' => $oneGameData['cat']
                ]);
                if (!empty($oneGameData['tags'])) {
                    $tagId = [];
                    foreach ($oneGameData['tags'] as $tag) {
                        $testTag = $tagModel->firstOrCreate(['name' => mb_strtolower($tag, "UTF-8")],
                            ['name' => mb_strtolower($tag, "UTF-8"), 'url' => $urlGenerator->createUrl($tag)]);
                        $tagId[] = $testTag->id;
                    }
                    //    dd($tagId);
                }
                $createdGame->tags()->attach($tagId);

                $category = $categoryModel->firstOrCreate(
                    ['cat_url' => $urlGenerator->createUrl($oneGameData['cat'])],
                    [
                        'cat_name' => $oneGameData['cat'],
                        'cat_url' => $urlGenerator->createUrl($oneGameData['cat']),
                        'cat_desc' => 'standard',
                        'cat_h1' => 'standard',
                        'cat_title' => 'standart'
                    ]);

                $category->game()->save($createdGame);
                //dd($category,$createdGame);
            }
        }
        return view('admin.gamedistribution',['message'=>'sdfsf']);
    }
}
