<?php

namespace App\Http\Controllers;

use App\Page;
use App\Post;
use App\PostCat;
use App\ProductCat;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class PostController extends Controller
{
    function index()
    {
        $posts = Post::paginate(10);
        return view('home.post.index', compact('posts'));
    }

    function detail(Request $request)
    {
        $post = Post::where('slug', '=', $request->slug)->first();
        $post->num_views += 1;
        $post->save();
        return view('home.post.detail', compact('post'));
    }

    function show_by_cat(Request $request)
    {
        $slug = $request->slug;
        $post_cat = PostCat::where('slug', '=', $slug)->first();
        $posts = $post_cat->posts->paginate(10);
        return view('home.post.show_by_cat', compact('posts', 'post_cat'));
    }

    function show_by_tag(Request $request)
    {
        $tag = $request->slug;
        $chosen_post_id = array();
        $posts = Post::get();
        foreach ($posts as $post) {
            $product_tags = explode(',', $post->tags);
            foreach ($product_tags as $product_tag) {
                if (Str::slug($product_tag, '-') == $tag) {
                    $chosen_post_id[] = $post->id;
                    break;
                }
            }
        }
        $posts = Post::whereIn('id', $chosen_post_id)->paginate(10);
        return view('home.post.show_by_tag', compact('tag', 'posts'));
    }
}
