<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
class Order extends Model
{
    protected $fillable = [
        'user_id',
        'status',
        'amount',
        'payment_method',
        'currency',
        'payment_intent_id',
        'client_secret',
        'reference',
        'items',
    ];

    protected $casts = [
        'items' => 'array',
        'amount' => 'integer',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($order) {
            if (empty($order->reference)) {
                $order->reference = Str::uuid();
            }
        });
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }
}

