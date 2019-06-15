<?php

namespace Deadzombies\Model;

use Deadzombies\Model\Tag;
use Illuminate\Database\Eloquent\Model;
use Deadzombies\Model\Category;

class Game extends Model
{
    public $timestamps = false;
    //public $primaryKey = 'gameid';
    public $guarded = [];

    public static function boot() {
        parent::boot();

        static::deleting(function($game) { // before delete() method call this
            $game->tags()->detach();
        });
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function tags()
    {
        return $this->belongsToMany(Tag::class);
    }

    public function image()
    {
        return $this->belongsToMany(Image::class);
    }

//    public function getRouteKeyName()
//    {
//        return 'game_url';
//    }

}
