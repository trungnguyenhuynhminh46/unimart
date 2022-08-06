<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $table = "orders";
    protected $fillable = ['id', 'username', 'name', 'email', 'address', 'phone_number', 'note', 'payment', 'status', 'total'];
    // Dòng ngày để ngăn không cho model ép id về int
    public $incrementing = false;
    function products()
    {
        return $this->belongsToMany('App\Product');
    }
    function orderItems()
    {
        return $this->hasMany('App\OrderItem', 'order_id', 'id');
    }
}
