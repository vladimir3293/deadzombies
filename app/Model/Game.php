<?php

namespace Deadzombies\Model;

use Illuminate\Database\Eloquent\Model;

class Game extends Model
{
    public $timestamps = false;
    public $primaryKey = 'id';
    public $guarded = [];

    public function category()
    {
        return $this->belongsTo('Deadzombies\Model\Category', 'game_cat','cat_id');
    }

    public function getRouteKeyName()
    {
        return 'game_url';
    }

}
