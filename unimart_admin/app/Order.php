<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $table = "orders";
    public $incrementing = false;
    function orderItems()
    {
        return $this->hasMany('App\OrderDetail', 'order_id', 'id');
    }
}
