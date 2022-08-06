<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PostCat extends Model
{
    protected $fillable = ['name', 'slug'];
    function posts()
    {
        return $this->hasMany('App\Post', 'cat_id', 'id');
    }
}
