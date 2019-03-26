<?php

namespace Deadzombies\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Deadzombies\Http\Controllers\Controller;

class ImagesController extends Controller
{
    public function addImage(Request $request)
    {
        $file = $request->file('img');

        $file->move('img', $file->getClientOriginalName());
    }

    public function addImageToPage()
    {

    }
}
