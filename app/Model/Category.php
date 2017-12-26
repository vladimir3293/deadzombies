<?php

namespace Deadzombies\Model;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    public $timestamps = false;
    //public $primaryKey = 'cat_id';

    public function game()
    {
        return $this->hasMany('Deadzombies\Model\Game','game_cat','cat_id');
    }

    public function getRouteKeyName()
    {
        return 'cat_url';
    }
}