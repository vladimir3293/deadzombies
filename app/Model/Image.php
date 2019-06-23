<?php

namespace Deadzombies\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Image extends Model
{
    public $timestamps = false;

    public $guarded = [];

    public function getRouteKeyName()
    {
        return 'name';
    }

    public static function boot()
    {
        parent::boot();

        static::deleting(function ($image) { // before delete() method call this
            if (Storage::disk('pub')->exists("/img/$image->name.jpg")) {
                Storage::disk('pub')->delete(["/img/$image->name.jpg"]);
            }
            if (Storage::disk('pub')->exists("/img/$image->name-small.jpg")) {
                Storage::disk('pub')->delete(["/img/$image->name-small.jpg"]);
            }
            if (Storage::disk('pub')->exists("/img/$image->name-large.jpg")) {
                Storage::disk('pub')->delete(["/img/$image->name-large.jpg"]);
            }
            $image->tag()->detach();
            $image->page()->detach();
            $image->category()->detach();
            $image->game()->detach();
        });
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
            $mainImg = $games->image;
            if ($mainImg->isNotEmpty()) {
                $games->img = '/img/' . $mainImg[0]->name . '.jpg';
                $games->imgAlt = $mainImg[0]->alt;
                $games->imgTitle = $mainImg[0]->title;
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
        if ($firstImgLarge && $gamesCollection->isNotEmpty()) {
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
            $mainImg = $category->image;
            if ($mainImg->isNotEmpty()) {
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
            $mainImg = $tag->image;
            if ($mainImg->isNotEmpty()) {
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
