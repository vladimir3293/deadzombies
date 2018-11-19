<?php

namespace Deadzombies\Http\Controllers\Admin;

use Deadzombies\Model\Category;
use Deadzombies\Model\Game;
use Deadzombies\Model\Tag;
use Deadzombies\Parser\Parser;
use Deadzombies\UrlGenerator\UrlGenerator;
use Exception;
use Illuminate\Contracts\Filesystem\Filesystem;
use Illuminate\Http\Request;
use Deadzombies\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;

class ParseController extends Controller
{
    //TODO another parser
    public function getParser()
    {
        $client = new \AlgoliaSearch\Client('TQARMJGO8A', '3690a3214c8934d794287d2d4c28d37f');



        $queries = [
            [
                'indexName' => 'prod_GAMEDISTRIBUTION',
                'query' => "",
                'hitsPerPage' => 10,
                'page'=> 1,
            ],

        ];

        $results = $client->multipleQueries($queries);
        $index = $client->initIndex('prod_GAMEDISTRIBUTION');

        $results = $index->browse('');
        dd($results);
//        $index->quer();
        dd($index);
        $curl = curl_init(); //инициализация сеанса
        curl_setopt($curl, CURLOPT_URL, 'https://tqarmjgo8a-dsn.algolia.net/1/indexes/*/queries?x-algolia-agent=Algolia%20for%20vanilla%20JavaScript%20(lite)%203.29.0%3BJS%20Helper%202.26.1%3Bvue-instantsearch%201.7.0&x-algolia-application-id=TQARMJGO8A&x-algolia-api-key=3690a3214c8934d794287d2d4c28d37f'); //урл сайта к которому обращаемся
        curl_setopt($curl, CURLOPT_HEADER, 1); //выводим заголовки
        curl_setopt($curl, CURLOPT_POST, 1); //передача данных методом POST
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1); //теперь curl вернет нам ответ, а не выведет
        curl_setopt($curl, CURLOPT_POSTFIELDS, //тут переменные которые будут переданы методом POST

            array(
                "indexName" => "prod_GAMEDISTRIBUTION",
//                "params" => "query=&hitsPerPage=20&page=10",

//                "params" => "query=&hitsPerPage=20&page=10&highlightPreTag=__ais-highlight__&highlightPostTag=__%2Fais-highlight__&filters=visible%3A1&facets=%5B%22tags%22%2C%22categories%22%2C%22company%22%2C%22type%22%5D&tagFilters=&facetFilters=%5B%5B%22type%3Ahtml5%22%5D%5D",
//                ["indexName"=>"prod_GAMEDISTRIBUTION","params"=>"query=&hitsPerPage=1&page=0&highlightPreTag=__ais-highlight__&highlightPostTag=__%2Fais-highlight__&filters=visible%3A1&attributesToRetrieve=%5B%5D&attributesToHighlight=%5B%5D&attributesToSnippet=%5B%5D&tagFilters=&analytics=false&clickAnalytics=false&facets=type"]
//            array (
//                'lastName'=>$_POST['lastName'],
//                'firstName'=>$_POST['firstName'],
//                'searchButton'=>'get' //это на случай если на сайте, к которому обращаемся проверяется была ли нажата кнопка submit, а не была ли оправлена форма
//            )
            ));
        curl_setopt($curl, CURLOPT_USERAGENT, 'MSIE 5'); //эта строчка как-бы говорит: "я не скрипт, я IE5" :)
        curl_setopt($curl, CURLOPT_REFERER, "http://ya.ru"); //а вдруг там проверяют наличие рефера
        $res = curl_exec($curl);
        dd($res);

        curl_close($curl);

        return view('admin.parser.gamedistribution');
    }

    //TODO img
//TODO WTFFFF
    public function postGameDist(Request $request, Tag $tagModel, Parser $parser, Category $categoryModel,
                                 Game $gameModel, UrlGenerator $urlGenerator, Filesystem $filesystem)
    {
        //get urls from one page
        $onePageRawUrl = collect($parser->getGamesUrls($request->page_number));
        $countOfGames = $onePageRawUrl->count();

        //first verification for unique
        $existUrls = $gameModel->pluck('original_url');
        $onePageUrls = $onePageRawUrl->diff($existUrls);
        ini_set('default_socket_timeout', 900);


//        $forTest[] = $onePageUrls[2];

        $countPages = 0;
        foreach ($onePageUrls as $oneGame) {

            $oneGameData = $parser->getGame($oneGame);
//TODO WTF WTF refactoring
            $game = $gameModel->where('game_url', $urlGenerator->createUrl($oneGameData['name']))->get();
            //dd($oneGameData['original_url']);

            if ($game->isEmpty()) {
                $countPages++;
                //dd(file_get_contents('https:' . $oneGameData['img']));
                //TODO filesystem
//                $this->createImage($urlGenerator->createUrl($oneGameData['name']),file_get_contents($oneGameData['img']));

                $this->createImage($urlGenerator->createUrl($oneGameData['name']), $oneGameData['img']);

                /*
                Storage::disk('pub')->put(
                    '/img/' . $urlGenerator->createUrl($oneGameData['name']) . '.jpg',
                    file_get_contents($oneGameData['img'])
                );
                */
                //dd($filesystem->);
                $createdGame = $gameModel->create([
                    'game_name' => $oneGameData['name'],
                    'game_url' => $urlGenerator->createUrl($oneGameData['name']),
                    'game_desc' => $oneGameData['desc'],
                    'game_title' => $oneGameData['name'],
                    'game_desc_meta' => $oneGameData['name'],
                    'game_key_meta' => $oneGameData['name'],
                    'game_control' => 'mouse keyboard',
                    'source' => $oneGameData['url'],
                    'img' => $oneGameData['img'],
                    'width' => $oneGameData['width'],
                    'height' => $oneGameData['height'],
                    'original_url' => $oneGameData['original_url']
                    //'category' => $oneGameData['cat']
                ]);
                if (!empty($oneGameData['tags'])) {
                    $tagId = [];
                    foreach ($oneGameData['tags'] as $tag) {
                        $testTag = $tagModel->firstOrCreate(
                            ['name' => mb_strtolower($tag, "UTF-8")],
                            [
                                'name' => mb_strtolower($tag, "UTF-8"),
                                'url' => $urlGenerator->createUrl($tag),
                                'display' => false
                            ]);
                        $tagId[] = $testTag->id;
                    }
                    //    dd($tagId);
                }
                $createdGame->tags()->attach($tagId);

                $category = $categoryModel->firstOrCreate(
                    ['cat_url' => $urlGenerator->createUrl($oneGameData['cat'])],
                    [
                        'cat_name' => $oneGameData['cat'],
                        'cat_url' => $urlGenerator->createUrl($oneGameData['cat']),
                        'cat_desc' => 'standard',
                        'cat_title' => 'standart',
                        'display' => false
                    ]);

                $category->game()->save($createdGame);
                //dd($category,$createdGame);
            }
        }
        return view('admin.parser.gamedistribution', ['message' => $countPages, 'countOfGames' => $countOfGames]);
    }

    //TODO WTFFFFF
    public function createImage(string $url, $img, string $imgPrefix = '')
    {
        //dd(exif_imagetype($img));
        $old_size = getimagesize($img);
//dd($old_size);
        $small_size = imagecreatetruecolor(80, 56);
        $medium_size = imagecreatetruecolor(220, 153);
        $large_size = imagecreatetruecolor(385, 268);

        if (exif_imagetype($img) != 2) {
            return;
        }


        $original = imagecreatefromjpeg($img);

        imagecopyresampled($small_size, $original, 0, 0, 0, 0, 80, 56, $old_size[0], $old_size[1]);
        imagecopyresampled($medium_size, $original, 0, 0, 0, 0, 220, 153, $old_size[0], $old_size[1]);
        imagecopyresampled($large_size, $original, 0, 0, 0, 0, 385, 268, $old_size[0], $old_size[1]);

        imagejpeg($small_size, public_path("/img/$url$imgPrefix-small.jpg"));
        imagejpeg($medium_size, public_path("/img/$url$imgPrefix.jpg"));
        imagejpeg($large_size, public_path("/img/$url$imgPrefix-large.jpg"));
    }
}
