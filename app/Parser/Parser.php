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
        $games = [];
        $parserDOM = $this->parseLib->file_get_html("https://www.gamedistribution.com/gamelist/allcompanies/allcategories/html5?selectedPage=$page");

        //dd($parserDOM->find('div.tiles'));
        $a = $parserDOM->find('div.tiles')[2]->find('a');
        foreach ($a as $card) {
            $games[] = 'https://gamedistribution.com' . htmlspecialchars_decode($card->href, ENT_QUOTES);
        }
        //dd($games);
        return $games;
    }

    //parser from gamedistr
    public function getGame($gameURL)
    {
        $gameURL = htmlspecialchars_decode($gameURL, ENT_QUOTES);
        $rawData = $this->parseLib->file_get_html($gameURL);
        $h1 = $rawData->find('h1')[0]->innertext;

        $h1 = htmlspecialchars_decode($h1, ENT_QUOTES);
        //img
        $imgUrl = $rawData->find('div.screenshots img')[0]->src;
        $imgUrl = 'https:' . $imgUrl;
        //game source
        //<script>
        //window.embedUrl = "https://html5.gamedistribution.com/dfe314edf3fc4986a76d555eb01dfbaf/";
        //</script>
        $gameUrl = $rawData->find('script');
        $gameUrl = $gameUrl[7]->innertext();
        $gameUrl = explode('=', $gameUrl)[1];
        $gameUrl = trim($gameUrl);
        $gameUrl = substr($gameUrl, 1, strlen($gameUrl) - 3);
        //tags
        $tagsRaw = $rawData->find('a.tag');
        $tags = [];
        foreach ($tagsRaw as $tag) {
            $tags[] = strtolower($tag->innertext);
        }
        //category
        $categoryRaw = $rawData->find('div#column2 p');
        $category = strtolower($categoryRaw[1]->innertext);
        //size
        $sizeRaw = $categoryRaw[3]->innertext;
        $size = explode(' ', $sizeRaw);
        $gameWidth = $size[0];
        $gameHeight = $size[2];
        //description
        $descRaw = $rawData->find('div#column1 p');
        $desc = $descRaw[0]->innertext;
        $desc = htmlspecialchars_decode($desc, ENT_QUOTES);
        $desc = trim($desc);
        return [
            'original_url' => $gameURL,
            'name' => $h1,
            'img' => $imgUrl,
            'url' => $gameUrl,
            'tags' => $tags,
            'cat' => $category,
            'width' => $gameWidth,
            'height' => $gameHeight,
            'desc' => $desc
        ];
    }
}