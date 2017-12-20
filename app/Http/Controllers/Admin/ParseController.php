<?php

namespace Deadzombies\Http\Controllers\Admin;

use Deadzombies\Model\Game;
use Deadzombies\Parser\Parser;
use Deadzombies\UrlGenerator\UrlGenerator;
use Illuminate\Http\Request;
use Deadzombies\Http\Controllers\Controller;

class ParseController extends Controller
{
    public function getParser(Parser $parser, Game $game, UrlGenerator $urlGenerator)
    {
        $onePageURL = $parser->getGamesUrls(2);
        $oneGame = $onePageURL[0];
        $oneGameData = $parser->getGame($oneGame);
        //dd($urlGenerator->urlCreate('fsd'));

//TODO tags, categories, img

        dd('fsd');
        //foreach ($onePageURL as $url) {
            $oneGameData = $parser->getGame($oneGame);
            $game->create([
                'game_name' => $oneGameData['name'],
                'game_url'=>$urlGenerator->urlCreate($oneGameData['name']),
                'game_desc' => $oneGameData['desc'],
                'game_title' => $oneGameData['name'],
                'game_desc_meta'=>$oneGameData['name'],
                'game_key_meta' => $oneGameData['name'],
                'game_control' => 'mouse keyboard',
                //TODO
                'game_cat' => 1,
                'source' => $oneGameData['url'],
                //TODO
                'img' => $oneGameData['img'],
                'width' => $oneGameData['width'],
                'height' => $oneGameData['height'],

                'category' => $oneGameData['cat']
            ]);
        //}

        return view('admin.parser');
    }

}
