<?php

namespace Deadzombies\Http\Controllers\Admin;

use Deadzombies\Model\Category;
use Deadzombies\Model\ForTest;
use Deadzombies\Model\Game;
use Deadzombies\Model\Tag;
use Deadzombies\Parser\Parser;
use Deadzombies\UrlGenerator\UrlGenerator;
use Exception;
use Illuminate\Contracts\Filesystem\Filesystem;
use Illuminate\Http\Request;
use Deadzombies\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class ParseController extends Controller
{
    //TODO another parser
    public function getParser()
    {


        return view('admin.parser.gamedistribution');
    }

    //TODO img
//TODO WTFFFF
    public function postGameDist(Request $request, Tag $tagModel, Parser $parser, Category $categoryModel,
                                 Game $gameModel, UrlGenerator $urlGenerator, Filesystem $filesystem, ForTest $forTest)
    {
        $client = new \AlgoliaSearch\Client('TQARMJGO8A', '3690a3214c8934d794287d2d4c28d37f');

        $index = $client->initIndex('prod_GAMEDISTRIBUTION');

        $rawResults = $index->browse('', ['offset' => 0, 'length' => 1000, 'facetFilters' => [
            "type:html5",
            "visible:1"
        ]]);

        $results = [];
//        $test = $rawResults;
//todo maybe to one foreach
        foreach ($rawResults as $hit) {
            $results[] = $rawResults->current();
//            if ($i == 5) {
//                break;
//            }
//            $i++;
        }
        dd($results);
//        var_dump($results);
//        $trust = $forTest->pluck('url')->search('100', true);
//
//        dd($results);
//        foreach ($results as $game) {
//            $forTest->create(['original_id' => $game['objectID'],
//                'title' => $game['title'],
//                'url' => $game['slugs'][0]['name']]);
//        }
//        dd($forTest->all());
//        $dublicats = DB::table('for_tests')->select('url')
//            ->groupBy('url')
//            ->having('url', '>', 45)
//            ->get();
//
//        dd($dublicats);

        $existId = $gameModel->pluck('original_id');


        $countOfGames = count($results);
        ini_set('default_socket_timeout', 3600);
        ini_set('max_execution_time', 3600);

        $countOfAddGames = 0;
        foreach ($results as $originalGame) {
            //first verification for unique
            $originalGameId = intval($originalGame['objectID']);
            if ($existId->search($originalGameId, true) === false) {

//                var_dump($existId[0],$originalGameId);
//                dd($existId,$originalGame, !$existId->search($originalGameId));

                $oneGameData['original_id'] = $originalGameId;
                $oneGameData['original_url'] = $originalGame['slugs'][0]['name'];
                $oneGameData['original_title'] = $originalGame['title'];
                $oneGameData['original_img'] = $originalGame['assets'][0]['name'];
                $oneGameData['original_description'] = $originalGame['description'];
                try {
                    $oneGameData['original_control'] = $originalGame['instruction'];
                } catch (\Exception $e) {
                    $oneGameData['original_control'] = 'control';
                }
                $oneGameData['game_name'] = $parser->translate($originalGame['title']);
                try {
                    $oneGameData['width'] = $originalGame['width'];
                } catch (\Exception $e) {
                    $oneGameData['width'] = 0;
                }
                try {
                    $oneGameData['height'] = $originalGame['height'];
                } catch (\Exception $e) {
                    $oneGameData['height'] = 0;
                }
                $oneGameData['source'] = $parser->getGameFromApi($oneGameData['original_url']);
                $oneGameData['game_url'] = $urlGenerator->createUrl($oneGameData['game_name']);
                $oneGameData['game_title'] = $oneGameData['game_name'];
                $oneGameData['game_desc_meta'] = $oneGameData['game_name'];
                $oneGameData['game_key_meta'] = $oneGameData['game_name'];
                if ($oneGameData['original_description']) {
                    $oneGameData['game_desc'] = $parser->translate($oneGameData['original_description']);
                } else {
                    $oneGameData['game_desc'] = 'opisanie';
                }
                if ($oneGameData['original_control']) {
                    $oneGameData['game_control'] = $parser->translate($oneGameData['original_control']);
                } else {
                    $oneGameData['game_control'] = 'control';
                }


                //second verification for unique
//                $game = $gameModel->where('game_url', $oneGameData['game_url'])->get();
//                if ($game->isEmpty()) {
                $countOfAddGames++;
                //TODO filesystem
//                $this->createImage($urlGenerator->createUrl($oneGameData['name']),file_get_contents($oneGameData['img']));
                $this->createImage($urlGenerator->createUrl($oneGameData['game_url']), 'https://img.gamedistribution.com/' . $oneGameData['original_img']);
                /*
                Storage::disk('pub')->put(
                    '/img/' . $urlGenerator->createUrl($oneGameData['name']) . '.jpg',
                    file_get_contents($oneGameData['img'])
                );
                */
                //dd($filesystem->);
                $gameTags = $originalGame['tags'];

                $createdGame = $gameModel->create($oneGameData);

                if (!empty($gameTags)) {
                    $tagId = [];
                    foreach ($gameTags as $tag) {
                        $translatedName = $parser->translate(mb_strtolower($tag, "UTF-8"));
                        $translatedUrl = $urlGenerator->createUrl($translatedName);
                        $testTag = $tagModel->firstOrCreate(
                            ['url' => $translatedUrl],
                            [
                                'name' => $translatedName,
                                'url' => $translatedUrl,
                                'display' => false,
                                'original_url' => mb_strtolower($tag, "UTF-8"),
                                'description' => $translatedName,
                                'meta_key' => $translatedName,
                                'meta_desc' => $translatedName,
                                'title' => $translatedName
                            ]);
                        $tagId[] = $testTag->id;
                    }
                    //    dd($tagId);
                    $createdGame->tags()->attach($tagId);
                }
                if (isset($originalGame['categories'][0])) {
                    $gameCategory = $parser->translate($originalGame['categories'][0]);
                    $category = $categoryModel->firstOrCreate(
                        ['cat_url' => $urlGenerator->createUrl($gameCategory)],
                        [
                            'cat_name' => $gameCategory,
                            'cat_url' => $urlGenerator->createUrl($gameCategory),
                            'cat_desc' => 'standard',
                            'cat_title' => 'standart',
                            'display' => false
                        ]);

                    $category->game()->save($createdGame);
                }
                //dd($category,$createdGame);
//                }
            }

        }
        return view('admin.parser.gamedistribution', ['message' => $countOfAddGames, 'countOfGames' => $countOfGames]);
    }

//TODO WTFFFFF
    public
    function createImage(string $url, $img, string $imgPrefix = '')
    {
        //dd(exif_imagetype($img));
        try {
            $old_size = getimagesize($img);
        } catch (\Exception $e) {
            return;
        }
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

    public
    function parseOne()
    {
        $countPages = 0;
        $oneGameData = $parser->getGameFromUrl($oneGame);
//TODO WTF WTF refactoring
        $game = $gameModel->where('game_url', $urlGenerator->createUrl($oneGameData['name']))->get();
        //dd($oneGameData['original_url']);

        if ($game->isEmpty()) {
            $countPages++;
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
        return view('admin.parser.gamedistribution', ['message' => $countPages, 'countOfGames' => $countOfGames]);
    }
}
