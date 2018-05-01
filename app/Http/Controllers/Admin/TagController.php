<?php

namespace Deadzombies\Http\Controllers\Admin;

use Deadzombies\Model\Tag;
use Deadzombies\UrlGenerator\UrlGenerator;
use Illuminate\Http\Request;
use Deadzombies\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class TagController extends Controller
{
    public function removeTag(Tag $Tag, Request $request)
    {
       //dd($Tag);
        $tag = $Tag->where('id', $request->tagId)->get()->first();
        //dd($tag);
        $Tag->Tag()->detach($tag);
        return redirect()->route('admin.getTag', [$Tag]);
    }

    public function addTag(Tag $Tag, Request $request)
    {
        //dd($Tag, $request);
        $tag = $Tag->where('id', $request->tagId)->get()->first();
        //dd($tag,$Game, $request);
        $Tag->Tag()->save($tag);
        return redirect()->route('admin.getTag', [$Tag]);
    }

    //TODO createName
    public function putTag(Tag $Tag, Request $request, UrlGenerator $urlGenerator)
    {
        //dd(request()->all());
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
        $categories = $Tag->category()->orderBy('id', 'desc')->get();
        $tags = $Tag->tag()->orderBy('id', 'desc')->get();
        $games = $Tag->game()->orderBy('id', 'desc')->get();
        $belongTag = $Tag->belongTag()->orderBy('id', 'desc')->get();
        $tagsAll = $Tag->orderBy('id', 'desc')->get();
        //dd($Tag->belongTag);
        return view('admin.tag', [
            'tag' => $Tag,
            'subTags' => $tags,
            'games' => $games,
            'categories' => $categories,
            'belongTags' => $belongTag,
            'tagsAll' => $tagsAll

        ]);
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
