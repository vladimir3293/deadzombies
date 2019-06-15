<?php

namespace Deadzombies\Model;

use Deadzombies\Model\Game;
use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    public $guarded = [];
    public $timestamps = false;

    public static function boot() {
        parent::boot();

        static::deleting(function($tag) { // before delete() method call this
            $tag->tagBelong()->detach();
            $tag->tag()->detach();
            $tag->game()->detach();
            $tag->category()->detach();
            // do the rest of the cleanup...
        });
    }

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
        return $this->belongsToMany(Tag::class,'tag_tag','tag_id','tag_id2');
    }

    public function tagBelong()
    {
        return $this->belongsToMany(Tag::class,'tag_tag','tag_id2','tag_id');
    }

    public function image()
    {
        return $this->belongsToMany(Image::class);
    }

    public function belongTag()
    {
        return $this->belongsToMany(Tag::class,'tag_tag','tag_id2','tag_id');
    }

    public function getRouteKeyName()
    {
        return 'url';
    }
}
