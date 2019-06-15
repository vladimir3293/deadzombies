<?php

namespace Deadzombies\Model;

use Illuminate\Database\Eloquent\Model;

class Image extends Model
{
    public $timestamps = false;

    public $guarded = [];

    public function getRouteKeyName()
    {
        return 'name';
    }

    public function page()
    {
        return $this->belongsToMany(Page::class);
    }

    public function category()
    {
        return $this->belongsToMany(Category::class);
    }

    public function game()
    {
        return $this->belongsToMany(Game::class);
    }

    public function tag()
    {
        return $this->belongsToMany(Tag::class);
    }

    public function makeGameImgUrl($gamesCollection, $firstImgLarge = false)
    {
        $gamesCollection->each(function ($games) {
            $games->url = route('getGame', $games->game_url, false);
            $mainImg = $games->image()->where('main_img', true)->get()->first();
            if (!empty($mainImg)) {
                $games->img = "/img/$mainImg->name.jpg";
                $games->imgAlt = $mainImg->alt;
                $games->imgTitle = $mainImg->title;
            } elseif (file_exists(public_path() . '/img/' . $games->game_url . '.jpg')) {
                $games->img = '/img/' . $games->game_url . '.jpg';
                $games->imgAlt = $games->game_name;
                $games->imgTitle = $games->game_title;
            } else {
                $games->img = '/img/site/empty.jpg';
                $games->imgAlt = 'пустое изображение';
                $games->imgTitle = 'пустое изображение';
            }
        });
        if ($firstImgLarge) {
            if ($gamesCollection[0]->img != '/img/site/empty.jpg') {
                $imgUrl = explode('.', $gamesCollection[0]->img);
                $gamesCollection[0]->img = $imgUrl[0] . '-large.jpg';
            }
        }
        return $gamesCollection;
    }

    public function makeCategoryImgUrl($categoryCollection)
    {
        $categoryCollection->each(function ($category) {
            $category->url = route('getCategory', ['cat' => $category->cat_url], false);
            //TODO delete dublicate
            $mainImg = $category->image()->where('main_img', true)->get()->first();
            if (!empty($mainImg)) {
                $category->img = "/img/$mainImg->name.jpg";
                $category->imgAlt = $mainImg->alt;
                $category->imgTitle = $mainImg->title;
            } elseif (file_exists(public_path() . '/img/' . $category->cat_url . '.jpg')) {
                $category->img = '/img/' . $category->cat_url . '.jpg';
                $category->imgAlt = $category->cat_title;
                $category->imgTitle = $category->cat_title;

            } else {
                $category->img = '/img/site/empty.jpg';
                $category->imgAlt = 'пустое изображение';
                $category->imgTitle = 'пустое изображение';
            }
        });
        return $categoryCollection;
    }

    public function makeTagImgUrl($tagsCollection)
    {
        $tagsCollection->each(function ($tag) {
            $tag->fullUrl = route('getTag', ['tag' => $tag->url], false);
            $mainImg = $tag->image()->where('main_img', true)->get()->first();
            if (!empty($mainImg)) {
                $tag->img = "/img/$mainImg->name.jpg";
                $tag->imgAlt = $mainImg->alt;
                $tag->imgTitle = $mainImg->title;
            } elseif (file_exists(public_path() . '/img/' . $tag->url . '.jpg')) {
                $tag->img = '/img/' . $tag->url . '.jpg';
                $tag->imgAlt = $tag->title;
                $tag->imgTitle = $tag->title;

            } else {
                $tag->img = '/img/site/empty.jpg';
                $tag->imgAlt = 'пустое изображение';
                $tag->imgTitle = 'пустое изображение';
            }
        });
        return $tagsCollection;
    }
}
