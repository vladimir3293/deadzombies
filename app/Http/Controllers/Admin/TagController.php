<?php

namespace Deadzombies\Http\Controllers\Admin;

use Deadzombies\Model\Tag;
use Deadzombies\UrlGenerator\UrlGenerator;
use Illuminate\Http\Request;
use Deadzombies\Http\Controllers\Controller;

class TagController extends Controller
{
    public function getTag(Tag $Tag)
    {
        //dd($Tag);
        return view('admin.tag',['tag'=>$Tag]);
    }

    public function deleteTag(Tag $Tag)
    {
        $Tag->delete();
        return redirect('/admin/tags');
    }

    public function postTag(Request $request, UrlGenerator $urlGenerator, Tag $tag)
    {
        if (!empty($request->tagName)) {
            $tag->name = $request->tagName;
            $tag->url = $urlGenerator->createUrl($request->tagName);
            $tag->save();
        }
        return redirect('/admin/tags');
    }

    public function getTags(Tag $tagModel)
    {
        $tagsAll = $tagModel->get();
        $tagsCount = $tagsAll->count();
        return view('admin.tags', ['tags' => $tagsAll, 'tagsCount' => $tagsCount]);
    }
}
