<?php

namespace Deadzombies\Http\Controllers;

use Deadzombies\Model\Tag;
use Illuminate\Http\Request;

class TagController extends Controller
{
    public function getTag(Tag $tag)
    {
        //TODO pagination
        //dd($tag);

        abort_unless($tag->display, 404);

        $games = $tag->game()->where('game_show', true)->simplePaginate(12);
        foreach ($games as $game) {
            $game->url = route('getGame', ['Game' => $game->game_url], false);
            $game->img = file_exists(public_path() . '/img/' . $game->game_url . '.jpg') ?
                '/img/' . $game->game_url . '.jpg' :
                '/img/site/empty.jpg';
        }
        $tag->tagsDisplayed = $tag->tag()->where('display', true)->get();
        //dd($tag);
        $tag->descWithP = '<p>'.str_replace(array("\r\n", "\r", "\n"), '</p><p>', $tag->description).'</p>';

        //dd($tag);
        return view('tag', ['games' => $games, 'tag' => $tag]);
    }
}
