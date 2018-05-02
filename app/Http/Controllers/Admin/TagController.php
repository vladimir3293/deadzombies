<?php

namespace Deadzombies\Http\Controllers\Admin;

use Deadzombies\Model\Tag;
use Deadzombies\UrlGenerator\UrlGenerator;
use Illuminate\Http\Request;
use Deadzombies\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class TagController extends Controller
{
    public function createTag()
    {
        return view('admin.tag.create');
    }
    public function getUnpublished(Tag $tagModel)
    {
        $tagsCount = $tagModel->where('display', 0)->get()->count();
        $tags = $tagModel->where('display', 0)->orderBy('id', 'desc')->simplePaginate(100);
        //dd($tags);
        $tags->each(function ($tag) {
            $tag->url = route('admin.getCategory', $tag->url);
        });
        return view('admin.tag.unpublished', ['tags' => $tags, 'tagsCount' => $tagsCount]);
    }

    public function getPublished(Tag $tagModel)
    {
        $tagsCount = $tagModel->where('display', 1)->get()->count();
        $tags = $tagModel->where('display', 1)->orderBy('id', 'desc')->simplePaginate(100);
        //dd($tags);
        $tags->each(function ($tag) {
            $tag->url = route('admin.getCategory', $tag->url);
        });
        return view('admin.tag.published', ['tags' => $tags, 'tagsCount' => $tagsCount]);
    }

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
    public function putTag(Tag $tag, Request $request, UrlGenerator $urlGenerator)
    {
        //dd(request()->all());
        $tag->title = $request->tagTitle;
        $tag->meta_desc = $request->tagMetaDesc;
        $tag->meta_key = $request->tagMetaKey;
        $tag->description = $request->tagDesc;
        if ($request->tagRename) {
            $tag->name = $request->tagRename;
            $newUrl = $urlGenerator->createUrl($request->tagRename);
            $tag->url = $newUrl;
        }
        if ($tag->display != $request->display) {
            $tag->display = $request->display;
        }
        $tag->save();
        //dd($Tag);
        return redirect()->route('admin.getTag', [$tag]);
    }

    public function getTag(Tag $Tag)
    {
        $categories = $Tag->category()->orderBy('id', 'desc')->get();
        $tags = $Tag->tag()->orderBy('id', 'desc')->get();
        $games = $Tag->game()->orderBy('id', 'desc')->get();
        $belongTag = $Tag->belongTag()->orderBy('id', 'desc')->get();
        $tagsAll = $Tag->orderBy('id', 'desc')->get();
        //dd($Tag->belongTag);
        return view('admin.tag.tag', [
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
        return redirect('/admin/tag/all');
    }

    public function postTag(Request $request, UrlGenerator $urlGenerator, Tag $tag)
    {
        if (!empty($request->tagName)) {
            $tag->name = $request->tagName;
            $tag->url = $urlGenerator->createUrl($request->tagName);
            $tag->save();
        }
        return redirect(route('admin.getTag',[$tag]));
    }

    public function getAll(Tag $tagModel)
    {
        //$tagsAll = $tagModel->get();
        $tagsAll = $tagModel->orderBy('id', 'desc')->simplePaginate(100);
        $tagsCount = $tagModel->get()->count();
        return view('admin.tag.all', ['tags' => $tagsAll, 'tagsCount' => $tagsCount]);
    }
}
