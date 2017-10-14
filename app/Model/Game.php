<?php

namespace Deadzombies\Model;

use Illuminate\Database\Eloquent\Model;

class Game extends Model
{
    public $timestamps = false;
    public $primaryKey = 'game_id';

    public function category()
    {
        return $this->belongsTo('Deadzombies\Model\Category','cat_id','game_cat');
}
}
