<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OrderDetail extends Model
{
    protected $table = "order_product";
    function product()
    {
        return $this->belongsTo('App\Product', 'product_id', 'id');
    }
    function order()
    {
        return $this->belongsTo('App\Order', 'order_id', 'id');
    }
}
