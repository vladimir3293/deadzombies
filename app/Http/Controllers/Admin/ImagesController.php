<?php

namespace Deadzombies\Http\Controllers\Admin;

use Deadzombies\Exceptions\ImageUploadException;
use Deadzombies\Model\Category;
use Deadzombies\Model\Game;
use Deadzombies\Model\Image;
use Deadzombies\Model\Page;
use Illuminate\Contracts\Filesystem\Filesystem;
use Illuminate\Http\Request;
use Deadzombies\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;

class ImagesController extends Controller
{
    public function getImage(Image $image)
    {

        return view('admin.images.image', ['image' => $image]);
    }

    //TODO validation
    public function putImage(Image $image, Request $request)
    {
        $image->title = $request->title;
        $image->alt = $request->alt;
        $image->main_img = $request->main_img;
        if (isset($request->main_img)) {
            $image->main_img = true;
        } else {
            $image->main_img = false;
        }
        $image->save();
        return view('admin.images.image', ['image' => $image]);
    }
    //TODO validation img
    //TODO alt title
    public function addImage(Request $request, Page $pageModel, Category $categoryModel,
                             Image $imageModel, Game $gameModel)
    {
        if (null !== $request->file('img')) {
            $file = $request->file('img');
            $nameImg = explode('.', $file->getClientOriginalName())[0];

            $existImg = $imageModel->where('name', $nameImg)->get();
            //TODO imgExist on disk
            if ($existImg->isNotEmpty()) {
                throw new ImageUploadException('Изображение с таким именем уже есть');
            }

            $this->createImage($nameImg, $file);
//            $file->move('img', $file->getClientOriginalName());
            $imageModel->name = $nameImg;
            $imageModel->save();
            if (isset($request->pageId)) {
                $page = $pageModel->where('id', $request->pageId)->get()->first();
                $page->image()->save($imageModel);
            } elseif (isset($request->categoryId)) {
                $category = $categoryModel->where('id', $request->categoryId)->get()->first();
                $category->image()->save($imageModel);
            } elseif (isset($request->gameId)) {
                $game = $gameModel->where('id', $request->gameId)->get()->first();
                $game->image()->save($imageModel);
            }
        }
        return redirect()->back();
    }

//TODO delete from game and category
    public function deleteImage(Image $image, Request $request, Page $pageModel,
                                Category $categoryModel, Game $gameModel)
    {
        if (isset($request->pageId)) {
            $page = $pageModel->where('id', $request->pageId)->get()->first();
            //dd($tag);
            $page->image()->detach($image);
        } elseif (isset($request->categoryId)) {
            $category = $categoryModel->where('id', $request->categoryId)->get()->first();
            $category->image()->detach($image);

        } elseif (isset($request->gameId)) {
            $game = $gameModel->where('id', $request->gameId)->get()->first();
            $game->image()->detach($image);
        }
        $image->delete();

        Storage::disk('pub')->delete("/img/$image->name.jpg");
        Storage::disk('pub')->delete("/img/$image->name-large.jpg");
        Storage::disk('pub')->delete("/img/$image->name-small.jpg");

        return redirect()->back();
    }

    public function addImageToPage(Page $page, Image $imageModel, Request $request)
    {
        if (null !== $request->file('img')) {
            $file = $request->file('img');
            $nameImg = explode('.', $file->getClientOriginalName())[0];

            $existImg = $imageModel->where('name', $nameImg)->get();
            //TODO imgExist on disk
            if ($existImg->isNotEmpty()) {
                throw new ImageUploadException('Изображение с таким именем уже есть');
            }

            $this->createImage($nameImg, $file);
//            $file->move('img', $file->getClientOriginalName());
            $imageModel->name = $nameImg;
            $imageModel->save();

            $page->image()->save($imageModel);
        }
        return redirect()->route('admin.pages.getPage', [$page]);

    }

    public
    function createImage(string $url, $img)
    {
        $old_size = getimagesize($img);

        $small_size = imagecreatetruecolor(80, 56);
        $medium_size = imagecreatetruecolor(220, 153);
        $large_size = imagecreatetruecolor(385, 268);

        $original = imagecreatefromjpeg($img);

        imagecopyresampled($small_size, $original, 0, 0, 0, 0, 80, 56, $old_size[0], $old_size[1]);
        imagecopyresampled($medium_size, $original, 0, 0, 0, 0, 220, 153, $old_size[0], $old_size[1]);
        imagecopyresampled($large_size, $original, 0, 0, 0, 0, 385, 268, $old_size[0], $old_size[1]);

        imagejpeg($small_size, public_path("/img/$url-small.jpg"));
        imagejpeg($medium_size, public_path("/img/$url.jpg"));
        imagejpeg($large_size, public_path("/img/$url-large.jpg"));
    }
}
