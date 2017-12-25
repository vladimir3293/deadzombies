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
    public function getParser(Parser $parser, Category $categoryModel, Game $game, UrlGenerator $urlGenerator)
    {
        $onePageURL = $parser->getGamesUrls(2);
        //dd($onePageURL);
        $oneGame = $onePageURL[0];
        $oneGameData = $parser->getGame($oneGame);
        //dd($urlGenerator->urlCreate('fsd'));
//$test = new \Deadzombies\Model\Tag();
//dd($test->all());
        $gameTest = $game->where('id',20)->get()->first();
        dd($gameTest->tag);
//TODO tags, categories, img

        //dd('fsd');
        //foreach ($onePageURL as $url) {


        $oneGameData = $parser->getGame($oneGame);

        $category = $categoryModel->where('cat_url', $urlGenerator->urlCreate($oneGameData['cat']))->get();
        if ($category->isNotEmpty()) {
            $oneGameData['cat_id'] = $category->first()->cat_id;
        } else {
            $categoryModel->cat_name = $oneGameData['cat'];
            $categoryModel->cat_url = $urlGenerator->urlCreate($oneGameData['cat']);
            $categoryModel->cat_title = 'standart';
            $categoryModel->cat_h1 = 'standart';
            $categoryModel->cat_desc = 'standart';
            $categoryModel->save();
            $oneGameData['cat_id'] = $categoryModel->cat_id;
        }

        $game->create([
            'game_name' => $oneGameData['name'],
            'game_url' => $urlGenerator->urlCreate($oneGameData['name']),
            'game_desc' => $oneGameData['desc'],
            'game_title' => $oneGameData['name'],
            'game_desc_meta' => $oneGameData['name'],
            'game_key_meta' => $oneGameData['name'],
            'game_control' => 'mouse keyboard',
            'game_cat' => $oneGameData['cat_id'],
            'source' => $oneGameData['url'],
            //TODO tags
            'img' => $oneGameData['img'],
            'width' => $oneGameData['width'],
            'height' => $oneGameData['height'],


            'category' => $oneGameData['cat']
        ]);
        dd($game);
        //}

        return view('admin.parser');
    }

}
