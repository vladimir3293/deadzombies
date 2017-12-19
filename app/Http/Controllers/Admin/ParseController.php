<?php

namespace Deadzombies\Http\Controllers\Admin;

use Deadzombies\Model\Game;
use Deadzombies\Parser\Parser;
use Illuminate\Http\Request;
use Deadzombies\Http\Controllers\Controller;

class ParseController extends Controller
{
    public function getParser(Parser $parser, Game $game)
    {
        //dd($game);
        $onePageURL = $parser->getGamesUrls(2);
        $oneGame = $onePageURL[0];
        $oneGameData = $parser->getGame($oneGame);
        //dd($oneGameData);

//TODO tags, categories, img
        //set_time_limit(0);
phpinfo();
dd('fsd');
        //foreach ($onePageURL as $url) {
            $oneGameData = $parser->getGame($url);
            $game->create([
                'game_name' => $oneGameData['name'],
              //TODO
                'game_url'=>'',
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

        //dd($game);
        /*
         foreach ($onePageURL as $url) {
             $oneGameData = $parser->getGame($url);

             $game->name = $oneGameData['name'];
             $game->source = $oneGameData['url'];
             $game->img = $oneGameData['img'];
             $game->width = $oneGameData['width'];
             $game->height = $oneGameData['height'];
             $game->desc = $oneGameData['desc'];
             $game->category = $oneGameData['cat'];
             $game->save();
         }
        */
        //   dd($game);


        return view('admin.parser');
    }

}
