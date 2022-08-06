<?php

namespace App\Http\Controllers;

use App\Page;
use App\PostCat;
use App\ProductCat;
use Illuminate\Http\Request;

class PageController extends Controller
{
    function term()
    {
        return view('home.page.term');
    }
    function detail(Request $request)
    {
        $page = Page::where('slug', '=', $request->slug)->first();
        return view('home.page.detail', compact('page'));
    }
}
