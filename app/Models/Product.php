<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use HasFactory;
    use SoftDeletes;

    public function tags()
    {
        return $this->belongsToMany('App\Models\Tag')->using('App\Models\ProductTag')->withTimestamps();
    }

    public function productTags()
    {
        return $this->hasMany('App\Models\ProductTag');
    }

    public function seller()
    {
        return $this->belongsTo('App\Models\Seller');
    }

    public function orderDetails()
    {
        return $this->hasMany('App\Models\OrderDetail');
    }
}
