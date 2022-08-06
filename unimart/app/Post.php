<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Post extends Model
{
    use SoftDeletes;
    protected $table = "posts";
    protected $fillable = [
        'user_id', 'summary', 'title', 'content', 'cat_id', 'thumbnail', 'status', 'slug'
    ];

    function category()
    {
        return $this->belongsTo('App\PostCat', 'cat_id', 'id');
    }

    function author()
    {
        return $this->belongsTo('App\User', 'user_id', 'id');
    }
}
