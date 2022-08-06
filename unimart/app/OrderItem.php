<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model
{
    protected $table = "order_product";
    protected $fillable = ['product_id', 'order_id', 'qty'];
    function product()
    {
        return $this->belongsTo('App\Product', 'product_id', 'id');
    }
    function order()
    {
        return $this->belongsTo('App\Order', 'order_id', 'id');
    }
}
