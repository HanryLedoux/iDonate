<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Donation extends Model
{
    protected $fillable = ['food_item_id', 'user_id', 'status', 'quantity'];

    protected $casts = [
        'quantity' => 'integer',
    ];

    public function foodItem()
    {
        return $this->belongsTo(FoodItem::class);
    }

    public function receiver()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
