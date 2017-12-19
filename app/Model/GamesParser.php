<?php

namespace Deadzombies\Model;

use Illuminate\Database\Eloquent\Model;

class GamesParser extends Model
{
    public $timestamps = false;
    protected $primaryKey = 'id';
    protected $table = 'p_games';
    protected $guarded = [];

    public function category()
    {
        return $this->belongsTo('Deadzombies\Model\Category', 'game_cat', 'cat_id');
    }

    public function getRouteKeyName()
    {
        return 'game_url';
    }
    //
}
