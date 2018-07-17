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
        //dd($h1);
        //img
        $imgUrl = $rawData->find('div.thumbnails');
        dd($imgUrl);
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
            $tags[] = $this->translate(strtolower($tag->innertext));
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