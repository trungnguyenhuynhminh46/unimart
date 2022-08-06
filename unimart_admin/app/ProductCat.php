<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProductCat extends Model
{
    protected $fillable = ['name', 'slug', 'parent_id'];
    function parent()
    {
        return $this->belongsTo('App\ProductCat', 'parent_id', 'id');
    }
}
