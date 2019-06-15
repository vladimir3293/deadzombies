<?php

namespace Deadzombies\Model;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    public $timestamps = false;
    //public $primaryKey = 'cat_id';
    public $guarded = [];

    public static function boot()
    {
        parent::boot();

        static::deleting(function ($category) { // before delete() method call this
            $category->tags()->detach();
        });
    }

    public function game()
    {
        return $this->hasMany('Deadzombies\Model\Game');
    }

    public function getRouteKeyName()
    {
        return 'cat_url';
    }

    public function tags()
    {
        return $this->belongsToMany(Tag::class);
    }

    public function image()
    {
        return $this->belongsToMany(Image::class);
    }
}