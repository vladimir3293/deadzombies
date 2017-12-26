<?php

namespace Deadzombies\Http\Controllers\Admin;

use Deadzombies\Model\Category;
use Deadzombies\Model\Game;
use Deadzombies\Parser\Parser;
use Deadzombies\UrlGenerator\UrlGenerator;
use Illuminate\Http\Request;
use Deadzombies\Http\Controllers\Controller;

class ParseController extends Controller
{
    public function getParser(\Deadzombies\Model\Tag $tagModel, Parser $parser, Category $categoryModel, Game $game, UrlGenerator $urlGenerator)
    {
        $onePageURL = $parser->getGamesUrls(2);
        //dd($onePageURL);
        $oneGame = $onePageURL[0];
        //$oneGameData = $parser->getGame($oneGame);
        //dd($urlGenerator->urlCreate('fsd'));
//$test = new \Deadzombies\Model\Tag();
//dd($test->all());
//TODO tags, categories, img, game empty

        //dd('fsd');
        //foreach ($onePageURL as $url) {


        $oneGameData = $parser->getGame($oneGame);
//check tags


        /*
               $createdGame = $game->create([
                    'game_name' => $oneGameData['name'],
                    'game_url' => $urlGenerator->urlCreate($oneGameData['name']),
                    'game_desc' => $oneGameData['desc'],
                    'game_title' => $oneGameData['name'],
                    'game_desc_meta' => $oneGameData['name'],
                    'game_key_meta' => $oneGameData['name'],
                    'game_control' => 'mouse keyboard',
                   // 'game_cat' => $oneGameData['cat_id'],
                    'source' => $oneGameData['url'],
                    //TODO tags
                    'img' => $oneGameData['img'],
                    'width' => $oneGameData['width'],
                    'height' => $oneGameData['height'],
                    //'category' => $oneGameData['cat']
                ]);
        */
//       $createdGame->tags()->attach()
        //$user->roles()->attach([ 1 => ['expires' => $expires], 2 => ['expires' => $expires] ])


        //dd($createdGame);
        if (!empty($oneGameData['tags'])) {
            $tagId = [];
            foreach ($oneGameData['tags'] as $tag) {
                $testTag = $tagModel->firstOrCreate(['name' => mb_strtolower($tag, "UTF-8")],
                    ['name' => mb_strtolower($tag, "UTF-8"), 'url' => $urlGenerator->urlCreate($tag)]);
                $tagId[] = $testTag->id;
            }
            dd($tagId);
        }

        $gameTest = $game->where('id', 20)->get()->first();
        dd($gameTest->tag);

        //check category, if empty create
        $category = $categoryModel->where('cat_url', $urlGenerator->urlCreate($oneGameData['cat']))->get();
        if ($category->isNotEmpty()) {
            $oneGameData['cat_id'] = $category->first()->cat_id;
        } else {
            //todo ->fill()
            $categoryModel->cat_name = $oneGameData['cat'];
            $categoryModel->cat_url = $urlGenerator->urlCreate($oneGameData['cat']);
            $categoryModel->cat_title = 'standart';
            $categoryModel->cat_h1 = 'standart';
            $categoryModel->cat_desc = 'standart';
            $categoryModel->save();
            $oneGameData['cat_id'] = $categoryModel->cat_id;
        }


        dd($game);
        //}

        return view('admin.parser');
    }

}
