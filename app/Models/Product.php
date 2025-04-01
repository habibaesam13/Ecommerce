<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable=[
        "name",
        "slug",
        "description",
        "price",
        "stock",
        "img",
        "discount_price",
    ];
    public function category()
    {
        return $this->belongsTo(Category::class);
    }
    public function orderItems()
    {
        return $this->hasMany(OrderItems::class);
    }
}
