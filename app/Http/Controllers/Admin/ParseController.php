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


        $forTest[] = $onePageUrls[2];

        $countPages = 0;
        foreach ($forTest as $oneGame) {

            $oneGameData = $parser->getGame($oneGame);
            dd($oneGameData);
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
