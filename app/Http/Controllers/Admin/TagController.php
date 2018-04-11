<?php

namespace Deadzombies\Http\Controllers\Admin;

use Deadzombies\Model\Tag;
use Illuminate\Http\Request;
use Deadzombies\Http\Controllers\Controller;

class TagController extends Controller
{
    public function getTags(Tag $tagModel)
    {
        $tagsAll = $tagModel->get();
        $tagsCount = $tagsAll->count();
    return view('admin.tags',['tags'=>$tagsAll,'tagsCount'=>$tagsCount]);
    }
}
