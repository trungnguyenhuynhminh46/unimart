<?php

namespace App\Http\Controllers;

use App\Page;
use App\PostCat;
use App\Product;
use App\ProductCat;
use Illuminate\Support\Str;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    function index()
    {
        $products = Product::orderBy('num_views', 'DESC')->get();
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
        // Chỉ lấy 8 phần tử đầu tiên
        foreach ($product_root_ids as $root_id => $product_ids) {
            if (count($product_ids) > 8) {
                $product_root_ids[$root_id] = array_slice($product_ids, 0, 8);
            }
        }
        return view('home.product.index', compact('product_root_ids'));
    }

    function search(&$all_cat_ids, $category)
    {
        if ($category->childCats != null) {
            foreach ($category->childCats as $childCat) {
                $this->search($all_cat_ids, $childCat);
            }
        }
        $all_cat_ids[] = $category->id;
    }

    function detail(Request $request)
    {
        $slug = $request->slug;
        // Sản phẩm 
        $product = Product::where('slug', '=', $slug)->first();
        $product->num_views += 1;
        $product->save();
        // Các sản phẩm cùng danh mục
        $category = $product->category;
        $same_category_products = $category->products;
        return view('home.product.detail', compact('product', 'same_category_products'));
    }

    function show_by_cat(Request $request)
    {
        $cat_id = $request->cat_id;
        $category = ProductCat::find($cat_id);
        $all_cat_ids = array();
        $this->search($all_cat_ids, $category);
        if (isset($request->input()['select'])) {
            $select = $request->input()['select'];
        } else {
            $select = 0;
        }
        // Trả về các sản phẩm theo thứ tự lựa chọn
        if ($select == 1) {
            $products = Product::whereIn('cat_id', $all_cat_ids)->orderBy('name', 'ASC')->paginate(48);
        } elseif ($select == 2) {
            $products = Product::whereIn('cat_id', $all_cat_ids)->orderBy('name', 'DESC')->paginate(48);
        } elseif ($select == 3) {
            $products = Product::whereIn('cat_id', $all_cat_ids)->orderBy('price', 'DESC')->paginate(48);
        } elseif ($select == 4) {
            $products = Product::whereIn('cat_id', $all_cat_ids)->orderBy('price', 'ASC')->paginate(48);
        } elseif ($select == 5) {
            $products = Product::whereIn('cat_id', $all_cat_ids)->orderBy('created_at', 'DESC')->paginate(48);
        } else {
            $products = Product::whereIn('cat_id', $all_cat_ids)->paginate(48);
        }
        return view('home.product.show_by_cat', compact('category', 'products', 'select'));
    }

    function show_by_tag(Request $request)
    {
        $tag = $request->slug;
        $chosen_product_ids = array();
        $products = Product::get();
        foreach ($products as $product) {
            $product_tags = explode(',', $product->tags);
            foreach ($product_tags as $product_tag) {
                if (Str::slug($product_tag) == $tag) {
                    $chosen_product_ids[] = $product->id;
                }
            }
        }
        if (isset($request->input()['select'])) {
            $select = $request->input()['select'];
        } else {
            $select = 0;
        }
        $products = Product::whereIn('id', $chosen_product_ids);
        // Trả về các sản phẩm theo thứ tự lựa chọn
        if ($select == 1) {
            $products = $products->orderBy('name', 'ASC')->paginate(48);
        } elseif ($select == 2) {
            $products = $products->orderBy('name', 'DESC')->paginate(48);
        } elseif ($select == 3) {
            $products = $products->orderBy('price', 'DESC')->paginate(48);
        } elseif ($select == 4) {
            $products = $products->orderBy('price', 'ASC')->paginate(48);
        } elseif ($select == 5) {
            $products = $products->orderBy('created_at', 'DESC')->paginate(48);
        } else {
            $products = $products->paginate(48);
        }
        return view('home.product.show_by_tag', compact('tag', 'products', 'select'));
    }

    function show_by_keyword(Request $request)
    {
        $keyword = $request->input()['keyword'];
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
        });
        if (isset($request->input()['select'])) {
            $select = $request->input()['select'];
        } else {
            $select = 0;
        }
        if ($select == 1) {
            $products = $products->orderBy('name', 'ASC')->paginate(48);
        } elseif ($select == 2) {
            $products = $products->orderBy('name', 'DESC')->paginate(48);
        } elseif ($select == 3) {
            $products = $products->orderBy('price', 'DESC')->paginate(48);
        } elseif ($select == 4) {
            $products = $products->orderBy('price', 'ASC')->paginate(48);
        } elseif ($select == 5) {
            $products = $products->orderBy('created_at', 'DESC')->paginate(48);
        } else {
            $products = $products->paginate(48);
        }
        return view('home.product.show_by_keyword', compact('keyword', 'select', 'products'));
    }
}
