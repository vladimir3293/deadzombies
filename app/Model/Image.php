<?php

namespace Deadzombies\Model;

use Illuminate\Database\Eloquent\Model;

class Image extends Model
{
    public $timestamps = false;

    public $guarded = [];

    public function getRouteKeyName()
    {
        return 'name';
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

}
