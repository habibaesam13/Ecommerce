<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable=[
        "name",
        "description",
        "price",
        "stock",
        "img",
        "discount_amount",
        "category_id",
    ];
public function scopeSearch($query, $search)
{
    return $query->where('id', $search)
        ->orWhere('name', 'like', "%{$search}%")
        ->orWhere('price', 'like', "%{$search}%")
        ->orWhereHas('category', function ($q) use ($search) {
            $q->where('name', 'like', "%{$search}%");
        });
}


public function getFinalPriceAttribute()
    {
        $discount = $this->discount_amount;
        $price = $this->price;

        if ($discount > 0) {
            $finalPrice = $price - ($price * ($discount / 100));
            return $finalPrice > 0 ? $finalPrice : 10;
        }

        return $price;
    }


    public function category()
    {
        return $this->belongsTo(Category::class);
    }
    public function orderItems()
    {
        return $this->hasMany(OrderItems::class);
    }

    public function favourites()
    {
        return $this->hasMany(Favourite::class);
    }
}
