<?php

namespace Deadzombies\Http\Controllers;

use Deadzombies\Model\Image;
use Deadzombies\Model\Tag;
use Illuminate\Http\Request;

class TagController extends Controller
{
    public function getTag(Tag $tag, Image $imageModel)
    {
        //TODO pagination
        //dd($tag);

        abort_unless($tag->display, 404);

        $tag->gamesDisplayed = $imageModel->makeGameImgUrl(
            $tag->game()->with(['image'
            => function ($query) {
                    $query->where('main_img', true)->first();
                }])
                ->where('game_show', true)
                ->simplePaginate(12)
        );

        $tag->tagsDisplayed = $imageModel->makeTagImgUrl(
            $tag->tag()->with(['image'
            => function ($query) {
                    $query->where('main_img', true)->first();
                }])
                ->where('display', true)
                ->get()
        );
        $tag->newGames = $imageModel->makeGameImgUrl(
            $tag->game()->with(['image'
            => function ($query) {
                    $query->where('main_img', true)->first();
                }])
                ->where('game_show', true)
                ->orderBy('game_id')
                ->limit(10)
                ->get()
        );
        $tag->bestGames = $imageModel->makeGameImgUrl(
            $tag->game()->with(['image'
            => function ($query) {
                    $query->where('main_img', true)->first();
                }])
                ->where('game_show', true)
                ->orderBy('game_like')
                ->limit(10)
                ->get()
        );
        //dd($tag);
        return view('tag', ['tag' => $tag]);
    }
}
