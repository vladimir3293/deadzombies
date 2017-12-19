<?php

namespace Deadzombies\Http\Controllers\Admin;

use Deadzombies\Model\GamesParser;
use Deadzombies\Parser\Parser;
use Illuminate\Http\Request;
use Deadzombies\Http\Controllers\Controller;

class ParseController extends Controller
{
    public function getParser(Parser $parser, GamesParser $game)
    {
        //dd($game);
        $onePageURL = $parser->getGamesUrls(2);
        $oneGame = $onePageURL[0];
        $oneGameData = $parser->getGame($oneGame);
        //dd($oneGameData);

//TODO tags
        set_time_limit(0);
phpinfo();
dd('fsd');
        foreach ($onePageURL as $url) {
            $oneGameData = $parser->getGame($url);
            $game->create([
                'name' => $oneGameData['name'],
                'source' => $oneGameData['url'],
                'img' => $oneGameData['img'],
                'width' => $oneGameData['width'],
                'height' => $oneGameData['height'],
                'desc' => $oneGameData['desc'],
                'category' => $oneGameData['cat']
            ]);
        }

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
