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

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function tags()
    {
        return $this->belongsToMany(Tag::class);
    }

//    public function getRouteKeyName()
//    {
//        return 'game_url';
//    }

}
