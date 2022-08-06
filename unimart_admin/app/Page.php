<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Page extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'author_id', 'summary', 'title', 'content', 'slug'
    ];
    function author()
    {
        return $this->belongsTo('App\User', 'author_id', 'id');
    }
}
