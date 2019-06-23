<?php

namespace Deadzombies\Http\Controllers\Admin;

use Deadzombies\Exceptions\TagDuplicateException;
use Deadzombies\Model\Tag;
use Deadzombies\UrlGenerator\UrlGenerator;
use Illuminate\Http\Request;
use Deadzombies\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

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
            $tag->url = route('admin.getTag', $tag->url);
        });
        return view('admin.tag.unpublished', ['tags' => $tags, 'tagsCount' => $tagsCount]);
    }

    public function getPublished(Tag $tagModel)
    {
        $tagsCount = $tagModel->where('display', 1)->get()->count();
        $tags = $tagModel->where('display', 1)->orderBy('id', 'desc')->simplePaginate(100);
        //dd($tags);
        $tags->each(function ($tag) {
            $tag->url = route('admin.getTag', $tag->url);
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
        if ($Tag->id == $request->tagId) {
            throw new TagDuplicateException('Нельзя привязать тег сам себе');
        }
        $tagAdd = $Tag->where('id', $request->tagId)->get()->first();

        //dd($tag,$Game, $request);
        $Tag->Tag()->save($tagAdd);
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
        $tag->h1 = $request->tagH1;
        if (null !== $request->file('img')) {
            $this->createImage($tag->url, $request->file('img'));
        }
        if ($request->tagRename) {
            $tag->name = $request->tagRename;
            $newUrl = $urlGenerator->createUrl($request->tagRename);
            if (Storage::disk('pub')->exists("/img/tags/$tag->url.jpg")) {
                Storage::disk('pub')->move("/img/tags/$tag->url.jpg", "/img/tags/$newUrl.jpg");
            }
            if (Storage::disk('pub')->exists("/img/tags/$tag->url-small.jpg")) {
                Storage::disk('pub')->move("/img/tags/$tag->url-small.jpg", "/img/tags/$newUrl-small.jpg");
            }
            if (Storage::disk('pub')->exists("/img/tags/$tag->url-large.jpg")) {
                Storage::disk('pub')->move("/img/tags/$tag->url-large.jpg", "/img/tags/$newUrl-large.jpg");
            }
            $tag->url = $newUrl;
        }
        if ($tag->display != $request->display) {
            $tag->display = $request->display;
        }
        $tag->save();
        //dd($Tag);
        return redirect()->route('admin.getTag', [$tag]);
    }

    public function getTag(Tag $tag)
    {
        $categories = $tag->category()->orderBy('id', 'desc')->get();
        $tags = $tag->tag()->orderBy('id', 'desc')->get();
        $games = $tag->game()->orderBy('id', 'desc')->get();
        $belongTag = $tag->belongTag()->orderBy('id', 'desc')->get();
        $tagsAll = $tag->orderBy('id', 'desc')->get();
        $tag->imgExist = $tag->image()->get();
        $tag->mainImg = $tag->image()->where('main_img', true)->get()->first();

        return view('admin.tag.tag', [
            'tag' => $tag,
            'subTags' => $tags,
            'games' => $games,
            'categories' => $categories,
            'belongTags' => $belongTag,
            'tagsAll' => $tagsAll

        ]);
    }

    public function deleteTag(Tag $Tag)
    {
        foreach ($Tag->image()->get() as $image) {
            $image->delete();
        }
        $Tag->delete();
        return redirect('/admin/tag/all');
    }

    public function postTag(Request $request, UrlGenerator $urlGenerator, Tag $tag)
    {
        if (!empty($request->tagName)) {
            $tag->name = $request->tagName;
            $tag->url = $urlGenerator->createUrl($request->tagName);
            $tag->save();
//            dd($tag);
        }
        return redirect(route('admin.getTag', [$tag]));
    }

    public function getAll(Tag $tagModel)
    {
        //$tagsAll = $tagModel->get();
        $tagsAll = $tagModel->orderBy('id', 'desc')->simplePaginate(100);
        $tagsCount = $tagModel->get()->count();
        return view('admin.tag.all', ['tags' => $tagsAll, 'tagsCount' => $tagsCount]);
    }

    //WTFFFFFF
    public function createImage(string $url, $img, string $imgPrefix = '')
    {
        $old_size = getimagesize($img);

        $small_size = imagecreatetruecolor(80, 56);
        $medium_size = imagecreatetruecolor(220, 153);
        $large_size = imagecreatetruecolor(385, 268);

        $original = imagecreatefromjpeg($img);

        imagecopyresampled($small_size, $original, 0, 0, 0, 0, 80, 56, $old_size[0], $old_size[1]);
        imagecopyresampled($medium_size, $original, 0, 0, 0, 0, 220, 153, $old_size[0], $old_size[1]);
        imagecopyresampled($large_size, $original, 0, 0, 0, 0, 385, 268, $old_size[0], $old_size[1]);

        imagejpeg($small_size, public_path("/img/tags/$url$imgPrefix-small.jpg"));
        imagejpeg($medium_size, public_path("/img/tags/$url$imgPrefix.jpg"));
        imagejpeg($large_size, public_path("/img/tags/$url$imgPrefix-large.jpg"));
    }
}
