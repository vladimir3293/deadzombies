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
        $gamesCards = $parserDOM->find('div.games-container')[0]->children();

        $gamesUrls = [];
        foreach ($gamesCards as $card) {
            $gameRawUrl = $card->find('a')[0]->href;
            $gamesUrls[] = 'https://gamedistribution.com' . htmlspecialchars_decode($gameRawUrl, ENT_QUOTES);
        }
        return $gamesUrls;
    }


    //parser from gamedistr
    public function getGame($gameURL)
    {
        $gameURL = htmlspecialchars_decode($gameURL, ENT_QUOTES);
        $rawData = $this->parseLib->file_get_html($gameURL);

        //h1
        $h1 = $rawData->find('h1')[0]->innertext;
        $h1 = htmlspecialchars_decode($h1, ENT_QUOTES);

        //img
        $imgContainer = $rawData->find('div.thumbnails');
        $imgOne = $imgContainer[0]->children(0)->find('img')[0];
        $imgUrl = $imgOne->attr['src'];

        //game source
        $gameUrlContainer = $rawData->find('div.input-container')[0];
        $gameUrl = $gameUrlContainer->find('input')[0]->attr['value'];

        //tags
        $tagsRaw = $rawData->find('div.tag-list a');
        $tags = [];
        foreach ($tagsRaw as $tag) {
            $tags[] = $this->translate(strtolower($tag->innertext));
        }

        //category
        $categoryRaw = $rawData->find('div.column')[3]->children(6)->children(1)->children(0)->innertext();
        $category = strtolower($categoryRaw);

        //size
        $sizeRaw = $rawData->find('div.column')[3]->children(4)->children(1)->innertext();
        $size = str_replace(' ','',explode('x', $sizeRaw));
        $gameWidth = $size[0];
        $gameHeight = $size[1];

        //description
        $descRaw = $sizeRaw = $rawData->find('div.column')[3]->children(8)->children(1)->innertext();
        $desc = htmlspecialchars_decode($descRaw, ENT_QUOTES);
        $desc = trim($desc);

        return [
            'original_url' => $gameURL,
            'name' => $this->translate($h1),
            'img' => $imgUrl,
            'url' => $this->translate($gameUrl),
            'tags' => $tags,
            'cat' => $this->translate($category),
            'width' => $gameWidth,
            'height' => $gameHeight,
            'desc' => $this->translate($desc)
        ];
    }

//TODO wtf
    public function translate(string $text)
    {

        $apiKey = 'AIzaSyBQU3PFax_Du60LhUX9smma_s_JJMFChvY';
//        $text = 'Hello world! i like some';

        $url = 'https://www.googleapis.com/language/translate/v2?key=' . $apiKey . '&q=' . rawurlencode($text) . '&source=en&target=ru';

        $handle = curl_init($url);
        curl_setopt($handle, CURLOPT_RETURNTRANSFER, true);
        $response = curl_exec($handle);
        $responseDecoded = json_decode($response, true);
        curl_close($handle);

        return $responseDecoded['data']['translations'][0]['translatedText'];
    }
}