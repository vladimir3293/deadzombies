<?php

namespace Deadzombies\Model;

use Deadzombies\Model\Tag;
use Illuminate\Database\Eloquent\Model;
use Deadzombies\Model\Category;

class Game extends Model
{
    public $timestamps = false;
    public $primaryKey = 'id';
    public $guarded = [];

    public function category()
    {
        return $this->belongsTo(Category::class, 'game_cat','cat_id');
    }

    public function tag()
    {
        return $this->belongsToMany(Tag::class);
    }

    public function getRouteKeyName()
    {
        return 'game_url';
    }

}
