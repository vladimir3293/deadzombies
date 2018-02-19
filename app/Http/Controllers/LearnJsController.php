<?php

namespace Deadzombies\Http\Controllers;

use Illuminate\Http\Request;

class LearnJsController extends Controller
{
    public function indexJs()
    {
        return view('admin.js');
    }
}
