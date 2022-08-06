<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProductCat extends Model
{
    protected $table = "product_cats";
    function parentCat()
    {
        return $this->belongsTo('App\ProductCat', 'parent_id', 'id');
    }
    function childCats()
    {
        return $this->hasMany('App\ProductCat', 'parent_id', 'id');
    }
    function products()
    {
        return $this->hasMany('App\Product', 'cat_id', 'id');
    }
}
