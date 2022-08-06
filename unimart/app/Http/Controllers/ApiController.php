<?php

namespace App\Http\Controllers;

use App\Product;
use App\ProductCat;
use Illuminate\Http\Request;

class ApiController extends Controller
{
    function ajaxSearch(Request $request)
    {
        $keyword = $request->keyword;
        $product_categories = ProductCat::where('name', 'LIKE', "%{$keyword}%")->get();
        $product_category_ids = array();
        foreach ($product_categories as $product_category) {
            $product_category_ids[] = $product_category->id;
        }
        $products = Product::where(function ($query) use ($keyword, $product_category_ids) {
            $query->where('name', 'LIKE', "%{$keyword}%")
                ->orWhere('content', 'LIKE', "%{$keyword}%")
                ->orWhere('summary', 'LIKE', "%{$keyword}%")
                ->orWhere('description', 'LIKE', "%{$keyword}%")
                ->orWhereIn('cat_id', $product_category_ids);
        })->limit(4)->get();
        return $products;
    }
}
