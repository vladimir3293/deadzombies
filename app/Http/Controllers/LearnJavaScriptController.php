<?php

namespace Deadzombies\Http\Controllers;

use Illuminate\Http\Request;

class LearnJavaScriptController extends Controller
{
    public function getIndex()
    {
        //dd('gd'< -5);
        return view('js');
    }
}
