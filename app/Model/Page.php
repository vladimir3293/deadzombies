<?php

namespace Deadzombies\Model;

use Illuminate\Database\Eloquent\Model;

class Page extends Model
{
    public $timestamps = false;

    public $guarded = [];
<<<<<<< Updated upstream
=======

    public function getRouteKeyName()
    {
        return 'url';
    }
    public function image()
    {
        return $this->belongsToMany(Image::class);
    }
>>>>>>> Stashed changes
}
