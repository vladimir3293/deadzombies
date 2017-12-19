<?php
namespace Deadzombies\Parser;

use Sunra\PhpSimple\HtmlDomParser;

class Parser
{
    private $parseLib;

    public function __construct(HtmlDomParser $parserLib)
    {
        $this->parseLib = $parserLib;
    }

    public function getGamesUrls($page)
    {
       $parserDOM = $this->parseLib->file_get_html("https://www.gamedistribution.com/gamelist/allcompanies/allcategories/html5?selectedPage=$page");
        $a = $parserDOM->find('div.tiles a');
        foreach ($a as $card) {
            $games[] = 'https://gamedistribution.com' . $card->href;

        }
        return $games;
    }

    public function getGame()
    {
        //$games = getGamesUrls();
        //echo $games[1];

        $rawData = new \simple_html_dom();
        $rawData->load_file("https://www.gamedistribution.com/games/1-player/asteroids.html");

        $h1 = $rawData->find('h1')[0]->innertext;
        $imgUrl = $rawData->find('div.screenshots img')[0]->src;
        $gameUrl = $rawData->find('div[data-type="url"]')[0]->children(1)->onclick;
        $gameUrl = explode('\'', $gameUrl)[1];
        $tagsRaw = $rawData->find('a.tag');
        foreach ($tagsRaw as $tag) {
            $tags[] = $tag->innertext;

        }
        $categoryRaw = $rawData->find('div#column2 p');
        $category = $categoryRaw[1]->innertext;
        $sizeRaw = $categoryRaw[3]->innertext;
        $size = explode(' ', $sizeRaw);

        $gameWidth = $size[0];
        $gameHeight = $size[2];

        $descRaw = $rawData->find('div#column1 p');
        $desc = $descRaw[0]->innertext;
    }
}