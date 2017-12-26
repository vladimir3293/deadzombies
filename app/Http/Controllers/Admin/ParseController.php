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
    public function getParser(\Deadzombies\Model\Tag $tagModel, Parser $parser, Category $categoryModel, Game $gameModel, UrlGenerator $urlGenerator)
    {
        $onePageURL = $parser->getGamesUrls(2);
        //dd($onePageURL);
        $oneGame = $onePageURL[0];
//TODO tags, categories, img, game empty

        //foreach ($onePageURL as $url) {

        $oneGameData = $parser->getGame($oneGame);

        $game = $gameModel->where('game_url', $urlGenerator->urlCreate($oneGameData['name']))->get();
        if ($game->isEmpty()) {
            $createdGame = $gameModel->create([
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

            //$user->roles()->attach([ 1 => ['expires' => $expires], 2 => ['expires' => $expires] ])


            //dd($createdGame);
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

            $category = $categoryModel->firstOrCreate(['cat_url' => $urlGenerator->urlCreate($oneGameData['cat'])],
                ['cat_url' => $urlGenerator->urlCreate($oneGameData['cat'])]);

            $category->game()->save($createdGame);
            //$createdGame->category()->save($category);
            /*
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
            */
        }
        return view('admin.parser');
    }
}
