<?php

namespace App\Http\Controllers;

use App\Page;
use App\Product;
use App\PostCat;
use App\ProductCat;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $products = Product::get();
        $product_root_ids = array();
        foreach ($products as $product) {
            // Tìm root id của category
            $root_category = $product->category;
            while ($root_category->parent_id != null) {
                $root_category = $root_category->parentCat;
            }
            $root_id = $root_category->id;
            $product_root_ids[$root_id][] = $product->id;
        }
        return view('home.index', compact('product_root_ids'));
    }
}
