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
}
