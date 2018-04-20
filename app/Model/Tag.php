<?php

namespace Deadzombies\Model;

use Deadzombies\Model\Game;
use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    public $guarded = [];
    public $timestamps = false;

    public function game()
    {
        return $this->belongsToMany(Game::class);
    }

    public function category()
    {
        return $this->belongsToMany(Category::class);
    }

    public function tag()
    {
        return $this->belongsToMany(Tag::class,'tag_tag','tag_id','id');
    }

    public function getRouteKeyName()
    {
        return 'url';
    }
}
