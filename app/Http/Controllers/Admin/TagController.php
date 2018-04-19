<?php

namespace Deadzombies\Http\Controllers\Admin;

use Deadzombies\Model\Tag;
use Deadzombies\UrlGenerator\UrlGenerator;
use Illuminate\Http\Request;
use Deadzombies\Http\Controllers\Controller;

class TagController extends Controller
{
    //TODO createName
    public function putTag(Tag $Tag, Request $request, UrlGenerator $urlGenerator)
    {
        $Tag->title = $request->tagTitle;
        $Tag->meta_desc = $request->tagMetaDesc;
        $Tag->meta_key = $request->tagMetaKey;
        $Tag->description = $request->tagDesc;
        if ($request->tagRename) {
            $Tag->name = $request->tagRename;
            $newUrl = $urlGenerator->createUrl($request->tagRename);
            $Tag->url = $newUrl;
        }
        $Tag->save();
        //dd($Tag);
        return redirect()->route('admin.getTag', [$Tag]);
    }

    public function getTag(Tag $Tag)
    {
        //dd($Tag);
        return view('admin.tag', ['tag' => $Tag]);
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
        //$tagsAll = $tagModel->get();
        $tagsAll = $tagModel->orderBy('id', 'desc')->simplePaginate(50);
        $tagsCount = $tagModel->get()->count();
        return view('admin.tags', ['tags' => $tagsAll, 'tagsCount' => $tagsCount]);
    }
}
