<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $table = 'products';
    function category()
    {
        return $this->belongsTo('App\ProductCat', 'cat_id', 'id');
    }
    function orders()
    {
        return $this->belongsToMany('App\Order');
    }
}
