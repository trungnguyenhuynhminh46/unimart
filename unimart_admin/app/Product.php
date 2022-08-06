<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use SoftDeletes;
    protected $fillable = [
        'name', 'summary', 'description', 'content', 'user_id', 'cat_id', 'price', 'old_price', 'qty', 'thumbnail', 'slug', 'tags'
    ];

    function user()
    {
        return $this->belongsTo('App\User', 'user_id', 'id');
    }

    function category()
    {
        return $this->belongsTo('App\ProductCat', 'cat_id', 'id');
    }
}
